@extends('layouts.app')
@push('css')
    <style>
        body {
            background-image: url('@asset("images/login-bg.jpg")');
            background-size: cover;
        }
    </style>
@endpush
@section('content')
    <div class=" mx-auto my-auto d-flex align-items-center" style="width: 55vh; height: 80vh;">
        <div class="card w-100 bg-black shadow-lg  rounded-4">

            <div class="card-body p-5 ">
                <img src="@asset('images/prompt-master-logo.png')" class="img-fluid mb-4" alt="Prompt Master Logo">
                <form method="POST" action="{{ route('login') }}">
                    @csrf


                    <div class="form-floating mb-3">
                        <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="dudezkie..." value="{{ old('username') }}" required autocomplete="username" autofocus>
                        <label class="text-muted" for="username">{{ __('Username') }}</label>
                    </div>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="form-floating">
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required autocomplete="current-password">
                        <label for="password">{{ __('Password') }}</label>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="d-flex flex-row justify-content-between gap-3 mt-3">

                        <div class="d-flex flex-column">

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>


                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-arrow-right me-2"></i> {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
