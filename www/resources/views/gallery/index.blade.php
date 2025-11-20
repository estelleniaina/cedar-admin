@extends("layout/app", [
    "title" => "Gallery photos"
])

@section("content")

    <x-filtre.panel>
        <div class="col-3">
            <x-filtre.select showAll="true" :data="$centres" name="centre_id" label="Centre" keyOption="id" labelOption="nom"></x-filtre.select>
        </div>
    </x-filtre.panel>

    <div style="display: flex; justify-content: space-between">
        <button type="button" class="btn btn-outline-success btn-sm" onclick="addGallery()">
            <i class="fas fa-plus-circle"></i> Ajouter
        </button>

        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deletePhoto()">
            <i class="fas fa-trash"></i> Supprimer
        </button>
    </div>

    <!-- boostrap company model -->
    <div class="modal fade modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="javascript:void(0)" id="GalleryForm" name="GalleryForm" class="form-horizontal" method="POST" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h4 class="modal-title modalTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <!-- Centre -->
                        <x-form.select label="Centre" required :data="$centres" name="centre_id" label="Centre"></x-form.select>

                        <!-- Images -->
                        <x-form.input-file name="image[]" placeholder="Choisir une photo" accept="image/*" label="Image" multiple="true"></x-form.input-file>
                    </div>
                    <x-modal.footer></x-modal.footer>
                </form>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->

    <div class="gallery-photos">
        <div class="loading">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> &nbsp;Chargement ...
        </div>

        <div id="item-lists">
            @include('gallery/images')
        </div>
    </div>

@endsection

@push("scripts")

    <script type="text/javascript">
        $('.loading').hide();
        var sDatatableId = 'datatable';
        var sFormId = 'GalleryForm';
        var dataFiltre = function(d) {
            d.centre_id = $('#centre_id').val();
        }

        $(function () {
            bsCustomFileInput.init(); // initialise upload file
        });

        function addGallery(){
            let sModalTitle = "Ajout photo";
            btnSetClick(sModalTitle);
        }

        function deletePhoto() {
            if (confirm('Voulez vous vraiment supprimer ces images?')) {
                let route = "{{ route('gallery.destroy')}}";
                let imageToDelete = $('input[type="checkbox"]') // get all checkboxes
                    .filter(':checked')  // get only checked
                    .toArray()  // convert jQuery collection to array
                    .reduce(function(acc, val) {
                        acc.push(val.value);
                        return acc;
                    }, []);
                $.ajax({
                    type: "DELETE",
                    url: route,
                    data: {image : imageToDelete},
                    dataType: 'json',
                    success: function (res) {
                        getData(1);

                        $(document).Toasts('create', {
                            class: 'bg-warning',
                            body: 'Suppression effectué avec succés'
                        })
                    }
                });
            }
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let route = "{{ route('gallery.store')}}";
            saveData(route, formData, sDatatableId)
        });

        let centreSelected;

        $('#searchForm').on('submit', function(e) {
            getData(1);
            e.preventDefault();
        });


        // List gallery
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                }else{
                    getData(page);
                }
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.pagination a',function(event) {
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                event.preventDefault();
                var page=$(this).attr('href').split('page=')[1];
                getData(page);
            });
        });

        function getData(page){
            let centreSelected = $('#centre_id').val() ?? '';
            $('.loading').show();
            $.ajax({
                    url: '?page=' + page + '&centre=' + centreSelected ,
                    type: "get",
                    datatype: "html",
                }).done(function(data) {
                    $('.loading').hide();
                    $("#item-lists").empty().html(data);
                    location.hash = page;
                })
        }

    </script>
@endpush
