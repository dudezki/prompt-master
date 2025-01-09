<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}
        {{-- if there is a section title then print --}}
        @hasSection('title')
            - @yield('title')
        @endif
    </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="@asset('images/favicon/apple-icon-57x57.png')">
    <link rel="apple-touch-icon" sizes="60x60" href="@asset('images/favicon/apple-icon-60x60.png')">
    <link rel="apple-touch-icon" sizes="72x72" href="@asset('images/favicon/apple-icon-72x72.png')">
    <link rel="apple-touch-icon" sizes="76x76" href="@asset('images/favicon/apple-icon-76x76.png')">
    <link rel="apple-touch-icon" sizes="114x114" href="@asset('images/favicon/apple-icon-114x114.png')">
    <link rel="apple-touch-icon" sizes="120x120" href="@asset('images/favicon/apple-icon-120x120.png')">
    <link rel="apple-touch-icon" sizes="144x144" href="@asset('images/favicon/apple-icon-144x144.png')">
    <link rel="apple-touch-icon" sizes="152x152" href="@asset('images/favicon/apple-icon-152x152.png')">
    <link rel="apple-touch-icon" sizes="180x180" href="@asset('images/favicon/apple-icon-180x180.png')">
    <link rel="icon" type="image/png" sizes="192x192"  href="@asset('images/favicon/android-icon-192x192.png')">
    <link rel="icon" type="image/png" sizes="32x32" href="@asset('images/favicon/favicon-32x32.png')">
    <link rel="icon" type="image/png" sizes="96x96" href="@asset('images/favicon/favicon-96x96.png')">
    <link rel="icon" type="image/png" sizes="16x16" href="@asset('images/favicon/favicon-16x16.png')">
    <link rel="manifest" href="@asset('images/favicon/manifest.json')">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="@asset('images/favicon/ms-icon-144x144.png')">
    <meta name="theme-color" content="#ffffff">


    @cssLink('plugins/bootstrap/5.3.3/css/bootstrap.min.css')
    @cssLink('plugins/bootstrap-icons/1.11.0/bootstrap-icons.min.css')
    @cssLink('plugins/select2/2.4.0.13/css/select2.min.css')
    @cssLink('plugins/select2/2.4.0.13/css/select2-bootstrap-5-theme.min.css')

    <!-- THIRD PARTY PLUGINS -->
    @cssLink('plugins/lightbox2/2.11.5/css/lightbox.min.css')
    @cssLink('plugins/toastr.js/css/toastr.min.css')

    @cssLink('global/css/custom.css')

    @stack('css')
</head>
<body>
<div id="app" class="">
    @auth
        @include('partials.navbar')
    @endauth

    <main class="container-fluid my-3">
        @yield('content')
    </main>

    @auth
        @include('modals.create')
    @endauth
</div>

<!-- Scripts -->

@scriptLink('plugins/jquery/3.6.0/jquery.min.js')
@scriptLink('plugins/bootstrap/5.3.3/js/bootstrap.bundle.min.js')
@scriptLink('plugins/lightbox2/2.11.5/js/lightbox.min.js')
@scriptLink('plugins/toastr.js/js/toastr.min.js')
@scriptLink('pages/global.js')
@stack('js')
@auth
    <script>
        GLOBAL.init();
    </script>
@endauth
</body>
</html>
