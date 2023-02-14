<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Upcube - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Custom Css-->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}" type="text/css">

    @yield('styles')

</head>

<body data-topbar="dark">

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
<div id="layout-wrapper">

    <!--Header Start-->
    @include('admin.body.header')
    <!--Header End-->

    <!-- ========== Left Sidebar Start ========== -->
    @include('admin.body.left_sidebar')
    <!-- Left Sidebar End -->

    <!--Main Content Start-->
    @yield('admin')
    <!--Main Content End-->

    <!--Footer Start-->
    @include('admin.body.footer')
    <!--Footer End-->

</div>
<!-- END layout-wrapper -->


<!-- JAVASCRIPT -->
<script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

<!--Toastr Alert Start-->
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch(type){
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
</script>
<!--Toastr Alert End-->

<!-- apexcharts -->
<script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- jquery.vectormap map -->
<script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('backend/assets/js/app.js') }}"></script>

@yield('js')

</body>


</html>
