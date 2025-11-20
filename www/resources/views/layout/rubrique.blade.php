@extends("layout/app", [
    "title" => "Gestion " . ($title ?? ' des données')
])

@section("content")

    <x-filtre.panel>
        <div class="col-3">
            <x-filtre.select showAll="true" :data="$centres" name="centre_id" label="Centre"></x-filtre.select>
        </div>
    </x-filtre.panel>

    <x-form.button-add funcAdd="addRubrique()"></x-form.button-add>

    <x-table :thead="$thead"></x-table>

    <!-- boostrap company model -->
    <div class="modal fade modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen modal-custom">
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

                            <!-- Centre -->
                            <x-form.select label="Centre" required :data="$centres" name="centre_id" label="Centre"></x-form.select>

                            <!-- Titre -->
                            <x-form.input label="Titre" name="titre" required placeholder="Titre"></x-form.input>

                            <!-- Upload Image -->
                            <x-form.input-file name="image" placeholder="Choisir une photo" accept="image/*" label="Image"></x-form.input-file>

                            <!-- Preview Image -->
                            <x-preview.image></x-preview.image>

                            <!-- Upload Fichier -->
                            <x-form.input-file name="fichier" placeholder="Choisir un fichier" accept=".doc, .docx, .ppt, .pptx, .pdf" label="Fichier PDF"></x-form.input-file>

                            <!-- Résumé -->
                            <x-form.textarea label="Résumé" name="resume" placeholder="Résumé"></x-form.textarea>

                            <!-- Video -->
                            <x-form.input-link label="Lien vidéo" name="lien" placeholder="Lien youtube">
                                <small id="linkHelp" class="form-text text-muted">Veillez mettre le embed/id de la video Youtube au lieu du lien </small>
                            </x-form.input-link>

                            <!-- Preview video -->
                            <x-preview.video name="file"></x-preview.video>

                            <!-- Descirption -->
                            <x-form.ckeditor label="Description" name="description" placeholder="Description" required></x-form.ckeditor>
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

        var dataFiltre = function(d) {
            d.centre_id = $('#centre_id').val();
            {{--d.type = {{  $type_rubrique ?? ''}};--}}
        }
        let oDtTable;

        $(function () {
            let route = "{{ $get_url ?? '' }}"
            let columns = [
                { data: 'id'},
                { data: 'centre'},
                { data: 'titre'},
                { data: 'resume'},
                {data : 'action', name: 'action', orderable: false},
            ];

            oDtTable = initialiseDatatable(sDatatableId, route, columns, dataFiltre, true);

            bsCustomFileInput.init(); // Initialise the custom file
        });

        function addRubrique(){
            let sModalTitle = " Ajout {{ $title ?? '' }}"
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let desc  = CKEDITOR.instances["description"].getData();
            desc = desc.replace('display:none', '');
            formData.set("description", desc );
            let route = "{{ $save_url ?? '' }}";
            saveData(route, formData, sDatatableId);
        });

        $('#searchForm').on('submit', function(e) {
            oDtTable.draw(true);
            e.preventDefault();
        });
    </script>
@endpush
