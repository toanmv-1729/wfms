<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <title>Work Flow Management System 2019</title>
    <link href="{{ asset('vendor/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    @stack('css')

    <link href="{{ asset('vendor/plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/plugins/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/plugins/css-chart/css-chart.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />

    <link href="{{ asset('vendor/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/css/colors/green.css') }}" id="theme" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar card-no-border logo-center">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">
        @include('layouts.header')

        @if(auth()->user()->is_admin)
            @include('layouts.admin_sidebar')
        @else
            @include('layouts.sidebar')
        @endif

        <div class="page-wrapper">
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>
    <script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('vendor/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('vendor/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('vendor/js/waves.js') }}"></script>
    <script src="{{ asset('vendor/js/sidebarmenu.js') }}"></script>

    <script src="{{ asset('vendor/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>

    <script src="{{ asset('vendor/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <script src="{{ asset('vendor/js/custom.min.js') }}"></script>
    @stack('js')
</body>

</html>
