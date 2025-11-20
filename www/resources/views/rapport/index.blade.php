@extends("layout/app", [
    "title" => "Gestion des rapports"
])

@section("content")

    <x-form.button-add funcAdd="addRapport()"></x-form.button-add>

    <x-table :thead="$thead"></x-table>

    <!-- boostrap company model -->
    <div class="modal fade modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="javascript:void(0)" id="addForm" name="addForm" class="form-horizontal" method="POST" enctype="multipart/form-data">

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
                        <x-form.input label="Titre" name="titre" required placeholder="Titre"></x-form.input>

                        <!-- Upload Fichier -->
                        <x-form.input-file name="fichier" placeholder="Choisir un fichier" accept=".pdf" label="Fichier PDF"></x-form.input-file>

                        <!-- Descirption -->
                        <x-form.textarea label="Description" name="description" placeholder="Description"></x-form.textarea>
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
        var sFormId = 'addForm';

        $(function () {
            let route = "{{ route('rapport.index')  }}"
            let columns = [
                { data: 'id'},
                { data: 'titre'},
                { data: 'description'},
                {data : 'action', name: 'action', orderable: false},
            ];

            oDtTable = initialiseDatatable(sDatatableId, route, columns, {}, true);
            bsCustomFileInput.init(); // Initialise the upload file
        });

        function addRapport(){
            let sModalTitle = " Ajout rapport"
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let route = "{{ route('rapport.store') }}";
            saveData(route, formData, sDatatableId);
        });
    </script>
@endpush
