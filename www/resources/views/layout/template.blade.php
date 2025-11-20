<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Application de l'orgation Cedar">
    <meta name="author" content="Cedar Ecovillage Madagascar">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cedar - Ecovillage Madagascar</title>

    <link rel="icon" href="{{asset("images/logo_cedar.png")}}" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("adminlte/plugins/fontawesome-free/css/all.min.css")}}">
{{--    <link rel="stylesheet" href="{{asset("fontawesome/css/all.css")}}">--}}
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset("adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("adminlte/dist/css/adminlte.min.css")}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset("adminlte/plugins/toastr/toastr.min.css")}}">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{asset("adminlte/plugins/ekko-lightbox/ekko-lightbox.css") }}">
    {{--    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">--}}
    <link rel="stylesheet" href="{{asset("css/style.css")}}">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        @if(Auth::user())
        <div class="dropdown ml-auto">
            <a class="dropdown-toggle color-brown" type="button" id="dropdownProfil" data-toggle="dropdown" aria-expanded="false">
                {{Auth::user()->name}}
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownProfil">
                <a class="dropdown-item" href="{{url("profil")}}">
                    <i class="nav-icon fas fa-user"></i> Profil
                </a>
                <a class="dropdown-item" href="{{url("logout")}}">
                    <i class="nav-icon fas fa-power-off"></i> Déconnexion
                </a>
            </div>
        </div>
        @endif

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar nav-bg elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{asset("images/logo_cedar.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">CEDAR</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar menu-top">

            @include('layout/nav')
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> {{$title ?? ''}}</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('subsection')
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2022 Cedar.</strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<script src="{{asset("adminlte/plugins/jquery/jquery.min.js")}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset("adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset("adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>

<script src="{{asset("adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
<script src="{{asset("adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
<script src="{{asset("adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js")}}"></script>
<script src="{{asset("adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}"></script>
<script src="{{asset("adminlte/plugins/datatables-buttons/js/buttons.html5.min.js")}}"></script>
<script src="{{asset("adminlte/plugins/datatables-buttons/js/buttons.print.min.js")}}"></script>
<script src="{{asset("adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("adminlte/dist/js/adminlte.min.js")}}"></script>
<!-- Toastr -->
<script src="{{asset("adminlte/plugins/toastr/toastr.min.js")}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset("adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js")}}"></script>
<!-- Ckeditor -->
<script src="{{asset("ckeditor/ckeditor.js")}}"></script>
<!-- Ekko Lightbox -->
<script src="{{asset("adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js")}}"></script>
{{--<script src="{{asset("js/bootstrap.bundle.min.js")}}"></script>--}}
<script src="{{asset("js/buttonAction.js")}}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let imgNoPhoto = "{{asset("images/no-image.jpg")}}";

    $(window).on('load', function (){

        for (key in CKEDITOR.instances) { CKEDITOR.instances[key].destroy(true); }

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

    });

    $('.popover-dismiss').popover({
        trigger: 'focus'
    })

</script>
<!-- Page specific script -->
@stack("scripts");

</body>
</html>
