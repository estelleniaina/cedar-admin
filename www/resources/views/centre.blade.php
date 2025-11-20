@extends("layout/app", [
    "title" => "Gestion des centres"
])

@section("sub-title")
    Liste des centres 2
@endsection

@section("content")

    <x-form.button-add funcAdd="addCentre()"></x-form.button-add>

    <x-table :thead="$thead"></x-table>

    <!-- boostrap company model -->
    <div class="modal fade modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-custom">
            <div class="modal-content">
                <form action="javascript:void(0)" id="CentreForm" name="CentreForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title modalTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <!-- Titre -->
                        <x-form.input label="Nom" name="nom" placeholder="Nom centre"></x-form.input>

                        <!-- Localisation -->
                        <x-form.input label="Localisation" name="localisation" placeholder="Localisation"></x-form.input>

                        <!-- Surface -->
                        <x-form.input label="Surface" name="surface" placeholder="Surface"></x-form.input>

                        <!-- Objectif -->
                        <x-form.ckeditor label="Objectif" name="objectif" placeholder="Objectif"></x-form.ckeditor>

                        <!-- Vision -->
                        <x-form.ckeditor label="Vision" name="vision" placeholder="Vision"></x-form.ckeditor>

                        <!-- Latitude -->
                        <x-form.textarea rows="2" label="Latitude" name="latitude" placeholder="Latitude"></x-form.textarea>

                        <!-- Longitude -->
                        <x-form.textarea rows="2" label="Longitude" name="longitude" placeholder="Longitude"></x-form.textarea>

                        <!-- Upload Image -->
                        <x-form.input-file name="photo" placeholder="Choisir une image" accept="image/*" label="Image" />

                        <!-- Preview Image -->
                        <x-preview.image />

                    </div>
                    <x-modal.footer></x-modal.footer>
                </form>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->
@endsection

@push("scripts")

    <script type="text/javascript">
        var sDatatableId = 'datatable';
        var sFormId = 'CentreForm';
        $(function () {
            let route = "{{ route('centre.list') }}"
            let columns = [
                { data: 'id', name: 'id' },
                { data: 'nom', name: '{{\App\Models\Centre::$colNom}}' },
                { data: 'localisation', name: '{{\App\Models\Centre::$colLocal}}' },
                {data : 'action', name: 'action', orderable: false},
            ];

            initialiseDatatable(sDatatableId, route, columns);

            bsCustomFileInput.init(); // Initialise the custom file
        });

        function addCentre(){
            let sModalTitle = "Ajout centre";
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let objectif  = window.btoa(CKEDITOR.instances["objectif"].getData());
            formData.set("objectif", objectif );

            let vision  = window.btoa(CKEDITOR.instances["vision"].getData());
            formData.set("vision", vision );

            let route = "{{ route('centre.store')}}";
            saveData(route, formData, sDatatableId)
        });
    </script>
@endpush
