@extends('layout/template')

@section('subsection')
    <!-- Main content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
{{--                    <div class="card-header">--}}
{{--                        <h3 class="card-title">@yield("sub-title")</h3>--}}
{{--                    </div>--}}
                    <div class="card-body">
                        @yield("content")
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    <!-- /.content -->

    <!-- Modal loading -->
    <div class="modal fade" id="modalLoading" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Récuperation...</span>
                        </div>
                        Récupération des données en cours...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
