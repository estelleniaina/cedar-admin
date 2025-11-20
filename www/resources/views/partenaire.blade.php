@extends("layout/app", [
    "title" => "Gestion des partenaires"
])

@section("sub-title")
    Liste des partenaires
@endsection

@section("content")

    <x-form.button-add funcAdd="addPartenaire()"></x-form.button-add>

    <x-table :thead="$thead"></x-table>

    <!-- boostrap company model -->
    <div class="modal fade modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="javascript:void(0)" id="PartenaireForm" name="PartenaireForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title modalTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <!-- Nom -->
                        <x-form.input label="Nom" name="nom" placeholder="Nom partenaire" />

                        <!-- Upload Image -->
                        <x-form.input-file name="logo" placeholder="Choisir le logo" accept="image/*" label="Logo" />

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
        var sFormId = 'PartenaireForm';
        $(function () {
            let route = "{{ route('partenaire.list') }}"
            let columns = [
                { data: 'id', name: 'id' },
                { data: 'nom', name: 'nom' },
                {data : 'action', name: 'action', orderable: false},
            ];

            initialiseDatatable(sDatatableId, route, columns);
            bsCustomFileInput.init(); // Initialise the custom file
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

            let route = "{{ route('partenaire.store')}}";
            saveData(route, formData, sDatatableId)
        });
    </script>
@endpush
