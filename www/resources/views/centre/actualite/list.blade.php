@extends("layout/app")
@section("title")
    Gestion des actualités des centres
@endsection

{{--@section("sub-title")--}}
{{--    Gestion des actualités des centres--}}
{{--@endsection--}}

@section("content")

    @include('centre/actualite/filtre')

    <button type="button" class="btn btn-outline-success btn-sm" onclick="addActualite()">
        <i class="fas fa-plus-circle"></i> Ajouter
    </button>

    <!-- /.card-header -->
    <table id="datatable" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Centre</th>
            <th>Titre</th>
            <th>Action</th>
        </tr>
        </thead>
    </table>
    <!-- /.card-body -->

    <!-- boostrap company model -->
    <div class="modal fade modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modalTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="ActualiteForm" name="ActualiteForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <!-- Centre -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Centre</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="centre_id" name="centre_id">
                                    @foreach($centres as $centre)
                                        <option value="{{ $centre["id"] }}"> {{ $centre["nom"] }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Titre -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Titre</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre actualité" required="">
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">Contenu</label>
                            <div class="col-sm-12">
                                <textarea class="form-control ckeditor" id="contenu" name="contenu" placeholder="Contenu" required=""></textarea>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-green" id="btn-save">Sauvegarder</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->
@endsection

@push("scripts")

    <script type="text/javascript">
        var sDatatableId = 'datatable';
        var sFormId = 'ActualiteForm';

        var dataFiltre = function(d) {
            d.titre = $('#titre').val();
            d.centre_id = $('#centre_id').val();
        }
        let oDtTable;
        $(function () {
            let route = "{{ route('list.centre-actualite') }}"
            let columns = [
                { data: 'id', name: 'id' },
                { data: 'centre', name: 'centre' },
                { data: 'titre', name: 'titre' },
                {data : 'action', name: 'action', orderable: false},
            ];

            oDtTable = initialiseDatatable(sDatatableId, route, columns, dataFiltre, true);
        });

        function addActualite(){
            let sModalTitle = "Ajout actualité";
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.set("contenu", CKEDITOR.instances["contenu"].getData() );

            let route = "{{ route('save.centre-actualite')}}";
            saveData(route, formData, sDatatableId)
        });

        $('#searchForm').on('submit', function(e) {
            oDtTable.draw(true);
            e.preventDefault();
        });
    </script>
@endpush
