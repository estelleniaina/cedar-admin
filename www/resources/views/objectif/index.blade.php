@extends("layout/app", [
    "title" => "Gestion objectifs"
])

@section("content")
    <x-table :thead="$thead"></x-table>

    <div class="modal fade modalEdit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addForm" name="addForm" class="form-horizontal">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title"></h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <x-form.input label="Contenu" name="contenu" required placeholder="Contenu"></x-form.input>
                    </div>
                    <x-modal.footer></x-modal.footer>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")

    <script type="text/javascript">
    var SITEURL = '';
    let sDatatableId = 'datatable';
    let sFormId = 'addForm';
    $(function () {
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        let route = "{{ route('objectif.index') }}";
        let columns = [
            { data: 'id', 'visible': false},
            { data: 'cle'},
            { data: 'contenu'},
            {data : 'action', name: 'action', orderable: false},
        ];

        oDtTable = initialiseDatatable(sDatatableId, route, columns, {}, true);

        // $('#' + sDatatableId +' tbody').on('click', 'tr .edit', function () {
        //     console.log('this', $('td', this).eq(1).text())
        //
        //     $('#productCrudModal').html("Modification objectif");
        //     $('#modalForm').modal('show');
        //
        //     let valeur = $('td', this).eq(1).text();
        //     $('#value').val(valeur);
        //     $('#id').val($(this).data('id'));
        // });

        $('#' + sDatatableId +' tbody').on('click', '#editBtn', function () {
            let selectedRow = oDtTable.row( $(this).parents('tr') ).data();
            console.log('selectedRow', selectedRow);
            $('#title').html("Modification objectif - " + selectedRow?.cle);
            $('.modalEdit').modal('show');
            $('#contenu').val(selectedRow?.contenu);
            $('#id').val($(this).data('id'));
        });

        // function deleteFunc(url){
        //     btnDelete(url, sDatatableId)
        // }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let route = "{{ route('objectif.store') }}";
            saveData(route, formData, sDatatableId);
        });
    });
</script>
@endpush
