<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Auth')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('mdi/css/materialdesignicons.min.css') }}">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" />
</head>
<body class="bg-light">
<div>
<nav
            class="navbar navbar-expand-sm navbar-dark bg-dark "
        >
            <div class="container ps-5 pe-5">
                <a class="navbar-brand ms-4" href="#"><img src="{{ asset('images/logo.png') }}" /></a>

                <div class="collapse navbar-collapse" id="collapsibleNavId">

                </div>
            </div>
        </nav>
        <div class="bg-success py-2">
        </div>
</div>    

    <div class="container">
        @yield('page')
    </div>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    
    <!-- End custom js for this page-->

    <script src="js/jquery.cookie.js" type="text/javascript"></script>
</body>
</html>
