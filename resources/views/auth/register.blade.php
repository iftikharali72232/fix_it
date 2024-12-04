@extends('layouts.app')

@section('content')
<div class="container-fluid" style="height: 100vh; background: linear-gradient(135deg, #FF6666, #FFA07A);">
    <div class="row h-100">
        <!-- Left Section with Illustration -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
            <img src="{{asset('img/construction_illusion.png')}}" alt="Construction Illustration" class="img-fluid" height="100%" width="100%;">
        </div>

        <!-- Right Section with Registration Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="card shadow-lg p-4" style="border-radius: 20px; width: 400px;">
                <div class="text-center mb-4">
                    <!-- Logo -->
                    <h1 class="text-danger fw-bold">FIX</h1>
                </div>

                <!-- Title -->
                <h5 class="text-center">{{ trans('lang.register') }}</h5>
                <!-- <p class="text-center text-muted small">{{ trans('lang.create_account') }}</p> -->

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Name Input -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ trans('lang.name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ trans('lang.email_address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email">
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
                               name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ trans('lang.confirm_password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" 
                               name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ trans('lang.register') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
