<nav class="navbar navbar-expand-md shadow py-1 fixed-top" style="background-color: #000">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}" >
            <img src="@asset('images/prompt-master-logo.png')" width="170" height="40"  alt="{{ config('app.name', 'Laravel') }}"/>
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
                <li class="nav-item">
                    <div class="h-100 btn-group me-2" role="group" aria-label="Basic checkbox toggle button group">
                        <input name="is_nsfw" type="checkbox" class="btn-check" id="btn_nsfw_all" autocomplete="off">
                        <label class="btn btn-outline-warning" for="btn_nsfw_all">
                            <i class="bi bi-eye-fill"></i>
                        </label>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddNew" class="nav-link me-3 px-4 bg-primary rounded-1" href="{{ route('home') }}">Create</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex flex-row align-items-center p-0 gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            </ul>
        </div>
    </div>
</nav>
