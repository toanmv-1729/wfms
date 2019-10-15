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
    <link href="{{ asset('vendor/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/css/colors/blue.css') }}" id="theme" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    @yield('content')
    
    <script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    @stack('js')
    <script src="{{ asset('vendor/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('vendor/js/waves.js') }}"></script>
    <script src="{{ asset('vendor/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('vendor/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('vendor/js/custom.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>
