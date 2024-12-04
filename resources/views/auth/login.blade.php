@extends('layouts.app')
@section('content')
<style>
    body {
    margin: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #FF6666, #FFA07A);
    height: 100vh;
}

.card {
    border: none;
    border-radius: 20px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    font-weight: bold;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

img {
    max-width: 100%;
}

</style>
<div class="container-fluid" style="height: 100vh; background: linear-gradient(135deg, #FF6666, #FFA07A);">
    <div class="row h-100">
        <!-- Left Section with Illustration -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
            <img src="{{asset('img/construction_illusion.png')}}" alt="Construction Illustration" class="img-fluid" height="100%" width="100%;" style="padding-top: 10%;">
        </div>

        <!-- Right Section with Login Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="card shadow-lg p-4" style="border-radius: 20px; width: 400px;">
                <div class="text-center mb-4">
                    <!-- Logo -->
                    <h1 class="text-danger fw-bold">FIX</h1>
                </div>

                <!-- Profile Icon -->
                <div class="text-center mb-3">
                    <img src="{{asset('img/user-circle.svg')}}" alt="User Icon" style="width: 80px; height: 80px; border-radius: 50%;">
                </div>

                <!-- Title -->
                <h5 class="text-center">{{ trans('lang.login_to_account') }}</h5>
                <p class="text-center text-muted small">{{ trans('lang.enter_username_password') }}</p>

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Username Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ trans('lang.username') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ trans('lang.password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ trans('lang.remember_me') }}
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ trans('lang.login') }}</button>
                    </div>

                    <!-- Forgot Password -->
                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="small">
                                {{ trans('lang.forgot_password') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
