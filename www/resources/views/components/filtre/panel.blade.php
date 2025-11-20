<div class="card card-filtre">
{{--    <div class="card-header">--}}
{{--        <h3 class="card-title"> Filtre </h3>--}}
{{--    </div>--}}
    <div class="card-body">
        <form method="POST" id="searchForm">
            @csrf
            <div class="row">

                {{ $slot }}

                <div class="col-3">
                    <button type="submit" class="btn btn-filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
