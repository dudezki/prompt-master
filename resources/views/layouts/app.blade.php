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
    <nav class="navbar navbar-expand-md shadow bg-primary">
        <div class="container-fluid ">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
                @hasSection('title')
                    - @yield('title')
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
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
