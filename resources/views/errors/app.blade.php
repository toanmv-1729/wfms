<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <title>Work Flow Management System 2019</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('vendor/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('vendor/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/css/colors/green.css') }}" id="theme" rel="stylesheet">
</head>

<body class="fix-header card-no-border logo-center">
    @yield('content')

    <script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/js/waves.js') }}"></script>
</body>

</html>
