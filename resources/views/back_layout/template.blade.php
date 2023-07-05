<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Portal - Bootstrap 5 Admin Dashboard Template For Developers</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="{{ asset('adminDesign/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('adminDesign/css/portal.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    @include('back_layout.navbar')

    @yield('content')

    <!-- Javascript -->
    <script src="{{ asset('adminDesign/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('adminDesign/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Charts JS -->
    <script src="{{ asset('adminDesign/plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('adminDesign/js/index-charts.js') }}"></script>

    <!-- Page Specific JS -->
    <script src="{{ asset('adminDesign/js/app.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ asset('adminDesign/js/jquery.js') }}"></script>


    @yield('scripts')
    @include('back_layout.footer')
</body>

</html>
