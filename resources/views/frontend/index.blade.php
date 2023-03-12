<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Admin Dashboard </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--Toastr Alert-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

    <!--Font Awesome Icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!--Custom Css-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">

    @yield('styles')
</head>

<body>



        <!--Header Start-->
        @include('frontend.body.header')
        <!--Header End-->


        <!--Main Content Start-->
        @yield('content')
        <!--Main Content End-->


        <!--Footer Start-->
        @include('frontend.body.footer')
        <!--Footer End-->


<!--Toastr Alert Js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

<!--JQuery-->
<script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>

<!--Bootstrap 5.2.3-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!--Ajax Js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--Sweet Alert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!--Sweet Alert / Code Js-->
{{--<script src="{{ asset('backend/assets/js/code.js') }}"></script>--}}

@yield('js')

</body>

</html>


