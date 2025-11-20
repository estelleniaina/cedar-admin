@extends("layout/app")
@section("title")
    Gestion capitalisation
@endsection

@section("sub-title")
    Liste des capitalisations
@endsection

@section("content")

    <button type="button" class="btn btn-outline-success btn-sm" onclick="addCapitalisation()">
        <i class="fas fa-plus-circle"></i> Ajouter
    </button>

    <!-- /.card-header -->
    <table id="datatable" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th> Fichier </th>
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
                    <form action="javascript:void(0)" id="CapitalisationForm" name="CapitalisationForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <!-- Upload file -->
                        <div class="form-group">
                            <label for="fichier"></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fichier" name="fichier" accept="application/pdf" value="{{ old('fichier') }}">
                                    <label class="custom-file-label" for="fichier">Choisir un fichier pdf</label>
                                </div>
                            </div>
                        </div>

                        <!-- Preview video -->
{{--                        <div id="videoFile">--}}
{{--                            <input type="hidden" name="file" id="file" value="{{old("file")}}">--}}
{{--                            <video height="200" autoplay muted controls id="file">--}}
{{--                                <source src="{{asset('upload/capitalisations/1656053597-Facebook_2.mp4')}}" type="video/mp4">--}}
{{--                                Your browser does not support the video tag.--}}
{{--                            </video>--}}
{{--                        </div>--}}

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
        var sFormId = 'CapitalisationForm';
        $(function () {

            let route = "{{ route('list.capitalisation') }}"
            let columns = [
                { data: 'id', name: 'id' },
                { data: 'fichier', name: 'fichier' },
                {data : 'action', name: 'action', orderable: false},
            ];

            initialiseDatatable(sDatatableId, route, columns);

            bsCustomFileInput.init(); // Initialise the custom file
        });

        function addCapitalisation(){
            let sModalTitle = "Ajout capitalisation";
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let route = "{{ route('save.capitalisation')}}";
            saveData(route, formData, sDatatableId)
        });

    </script>
@endpush
