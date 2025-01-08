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

    @cssLink('global/css/custom.css')

    <style>
        /*
        html, body, #app {
            height: 100%;
            overflow: hidden !important;
        }
        main {
            overflow-y: auto;
            height: 100%;
        }
        */
    </style>

    @stack('css')
</head>
<body>
<div id="app" class="">
    <nav class="navbar navbar-expand-md shadow py-0" style="background-color: #b6481e">
        <div class="container-fluid ms-0 ps-1">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="@asset('images/favicon/apple-icon-60x60.png')" width="50" height="50"  alt="{{ config('app.name', 'Laravel') }}"/>
                {{ config('app.name', 'Laravel') }}
                @hasSection('title')
                    - @yield('title')
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex flex-row align-items-center p-0 gap-2" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex flex-row gap-2 align-self-center">
                                    <picture>
                                        @if(Auth::user() && Auth::user()->avatar)
                                            <img src="data:image/png;base64,{{ Auth::user()->avatar }}" alt="User Avatar" class="rounded-circle" width="40" height="40">
                                        @else
                                            <img src="{{ asset('assets/images/default-avatar.png') }}" alt="Default Avatar" class="rounded-circle" width="40" height="40">
                                        @endif
                                    </picture>
                                    <span class="d-flex flex-column">
                                        <span>{{ Auth::user()->username }}</span>
                                        <span class="text-muted" style="font-size: 11px;">{{Auth::user()->name}}</span>
                                    </span>
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid my-3">
        @yield('content')
    </main>
</div>

@scriptLink('plugins/jquery/3.6.0/jquery.min.js')
@scriptLink('plugins/bootstrap/5.3.3/js/bootstrap.bundle.min.js')

@stack('js')
</body>
</html>
