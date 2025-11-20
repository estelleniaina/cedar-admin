@extends("layout/app")
@section("title")
    Gestion des partenaires
@endsection

@section("sub-title")
    Liste des partenaires
@endsection

@section("content")

    <button type="button" class="btn btn-outline-success btn-sm" onclick="addPartenaire()">
        <i class="fas fa-plus-circle"></i> Ajouter
    </button>

    <!-- /.card-header -->
    <table id="datatable" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
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
                    <form action="javascript:void(0)" id="PartenaireForm" name="PartenaireForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <!-- Nom -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nom</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Titre partenaire" required="">
                            </div>
                        </div>

                        <!-- Upload file -->
                        <div class="form-group">
                            <label for="logo"></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="logo" name="logo"  accept="image/*" value="{{ old('logo') }}">
                                    <label class="custom-file-label" for="logo">Choisir une photo</label>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Image -->
                        <div class="col-md-12 mb-2 text-center">
                            <img id="preview-image" src="{{asset("images/no-image.jpg")}}"
                                 alt="Apercu de l'image" style="max-height: 250px;">
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
        var sFormId = 'PartenaireForm';
        $(function () {
            let route = "{{ route('list.partenaire') }}"
            let columns = [
                { data: 'id', name: 'id' },
                { data: 'nom', name: 'nom' },
                {data : 'action', name: 'action', orderable: false},
            ];

            initialiseDatatable(sDatatableId, route, columns);

            bsCustomFileInput.init(); // Initialise the custom file

            // Show preview
            $('#logo').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });

        function addPartenaire(){
            let sModalTitle = "Ajout partenaire";
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let route = "{{ route('save.partenaire')}}";
            saveData(route, formData, sDatatableId)
        });
    </script>
@endpush
