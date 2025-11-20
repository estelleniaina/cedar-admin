@extends("layout/app", [
    "title" => "Gestion des catégories"
])

@section("sub-title")
    Liste des catégories
@endsection

@section("content")

    <x-form.button-add funcAdd="addCategorie()"></x-form.button-add>

    <x-table :thead="$thead"></x-table>

    <!-- boostrap company model -->
    <div class="modal fade modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-custom">
            <div class="modal-content">
                <form action="javascript:void(0)" id="CategorieForm" name="CategorieForm" class="form-horizontal" method="POST">
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
                        <x-form.input label="Titre" name="titre" placeholder="Titre catégorie"></x-form.input>

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
        var sFormId = 'CategorieForm';
        $(function () {
            let route = "{{ route('categorie.list') }}"
            let columns = [
                { data: 'titre', name: '{{\App\Models\Categorie::$colTitle}}' },
                {data : 'action', name: 'action', orderable: false},
            ];

            initialiseDatatable(sDatatableId, route, columns);

            bsCustomFileInput.init(); // Initialise the custom file
        });

        function addCategorie(){
            let sModalTitle = "Ajout catégorie";
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let route = "{{ route('categorie.store')}}";
            saveData(route, formData, sDatatableId)
        });
    </script>
@endpush
