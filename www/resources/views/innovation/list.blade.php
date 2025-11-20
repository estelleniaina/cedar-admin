@extends("layout/app")
@section("title")
    Gestion des innovations
@endsection

@section("sub-title")
    Liste des innovations
@endsection

@section("content")
    @include("layout/filtre")

    <button type="button" class="btn btn-outline-success btn-sm" onclick="addInnovation()">
        <i class="fas fa-plus-circle"></i> Ajouter
    </button>

    <!-- /.card-header -->
    <table id="datatable" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Centre</th>
            <th>Fichier</th>
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
                    <form action="javascript:void(0)" id="InnovationForm" name="InnovationForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
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


                        <!-- Upload file -->
                        <div class="form-group">
                            <label for="fichier"></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" name="file" value="{{ old('file') }}" accept=".doc, .docx, .ppt, .pptx, .pdf">
                                    <label class="custom-file-label" for="file">Choisir un fichier</label>
                                </div>
                            </div>
                        </div>

                        <!-- Lien -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lien</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://</span>
                                </div>
                                <input class="form-control" type="text" placeholder="Lien du fichier" name="lien" id="lien" value="{{ old('lien') }}">
                            </div>
                        </div>

                        <!-- Preview video -->
{{--                        <div id="videoFile">--}}
{{--                            <input type="hidden" name="file" id="file" value="{{old("file")}}">--}}
{{--                            <video height="200" autoplay muted controls id="file">--}}
{{--                                <source src="{{asset('upload/innovations/1656053597-Facebook_2.mp4')}}" type="video/mp4">--}}
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
        var sFormId = 'InnovationForm';

        var dataFiltre = function(d) {
            d.centre_id = $('#centre_id').val();
        }
        let oDtTable;
        $(function () {
            let route = "{{ route('list.innovation') }}"
            let columns = [
                { data: 'id', name: 'id' },
                { data: 'centre', name: 'centre' },
                { data: 'file', name: 'file' },
                {data : 'action', name: 'action', orderable: false},
            ];

            oDtTable = initialiseDatatable(sDatatableId, route, columns, dataFiltre, true);

            bsCustomFileInput.init(); // Initialise the custom file
        });

        function addInnovation(){
            let sModalTitle = "Ajout innovation";
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let route = "{{ route('save.innovation')}}";
            saveData(route, formData, sDatatableId)
        });

        $('#searchForm').on('submit', function(e) {
            oDtTable.draw(true);
            e.preventDefault();
        });

    </script>
@endpush
