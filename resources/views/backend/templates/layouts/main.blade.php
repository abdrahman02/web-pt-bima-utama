<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PT. DAHLIA BINA UTAMA</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/css/vendor.bundle.base.css') }}">
    <!-- endinject -->

    {{-- SELECT2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- EndSelect2 --}}

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->

    <link rel="shortcut icon" href="{{ asset('img/logo-pt.jpg') }}" type="image/x-icon">

    @stack('custom-css')
</head>

<body>
    <div class="content-wrapper">
        <div class="row">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{ asset('backend/js/jquery-cookie.js') }}"></script>

    <!-- plugins:js -->
    <script src="{{ asset('backend/vendor/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->

    <!-- inject:js -->
    <script src="{{ asset('backend/js/off-canvas.js') }}"></script>
    <script src="{{ asset('backend/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('backend/js/template.js') }}"></script>
    <script src="{{ asset('backend/js/settings.js') }}"></script>
    <script src="{{ asset('backend/js/todolist.js') }}"></script>
    <!-- endinject -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('custom-js')

</body>

</html>