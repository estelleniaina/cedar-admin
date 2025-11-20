@extends("layout/app")
@section("title")
    Gestion des testimonials
@endsection

@section("sub-title")
    Liste des testimonials
@endsection

@section("content")

    <button type="button" class="btn btn-outline-success btn-sm" onclick="addTestimonial()">
        <i class="fas fa-plus-circle"></i> Ajouter
    </button>

    <!-- /.card-header -->
    <table id="datatable" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Fonction</th>
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
                    <form action="javascript:void(0)" id="TestimonialForm" name="TestimonialForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <!-- Nom -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Titre</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required="">
                            </div>
                        </div>

                        <!-- Fonction -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Fonction</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="fonction" name="fonction" placeholder="Fonction">
                            </div>
                        </div>

                        <!-- Témoignage -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Témoignage</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="temoignage" name="temoignage" placeholder="Témoignage" required=""></textarea>
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
        var sFormId = 'TestimonialForm';
        $(function () {
            let route = "{{ route('list.testimonial') }}"
            let columns = [
                { data: 'id', name: 'id' },
                { data: 'nom', name: 'nom' },
                { data: 'fonction', name: 'fonction' },
                {data : 'action', name: 'action', orderable: false},
            ];

            initialiseDatatable(sDatatableId, route, columns);
        });

        function addTestimonial(){
            let sModalTitle = "Ajout testimonial";
            btnSetClick(sModalTitle);
        }

        function deleteFunc(url){
            btnDelete(url, sDatatableId)
        }

        $('#'+sFormId).submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            let route = "{{ route('save.testimonial')}}";
            saveData(route, formData, sDatatableId)
        });
    </script>
@endpush
