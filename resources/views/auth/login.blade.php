@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Login'],
];
@endphp

<div class="min-vh-80 d-flex align-items-center justify-content-center">
    <div class="w-100" style="max-width: 400px;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-primary rounded-3" style="width: 64px; height: 64px;">
                <i class="fas fa-user-md fa-2x text-white"></i>
            </div>
            <h2 class="fw-bold text-dark">Welcome Back</h2>
            <p class="text-muted">Sign in to your account</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="/login" class="d-flex flex-column gap-3">
                    @csrf

                    <div>
                        <label for="email" class="form-label fw-medium">
                            <i class="fas fa-envelope text-muted me-2"></i>Email Address *
                        </label>
                        <div class="input-icon-wrapper">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="form-control ps-4" placeholder="doctor@hospital.com">
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="form-label fw-medium">
                            <i class="fas fa-lock text-muted me-2"></i>Password *
                        </label>
                        <div class="input-icon-wrapper">
                            <input type="password" id="password" name="password" required
                                   class="form-control ps-4" placeholder="••••••••">
                            <div class="icon"><i class="fas fa-lock"></i></div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label small" for="remember">Keep me logged in</label>
                        </div>
                        <a href="#" class="small text-primary fw-medium text-decoration-none">Forgot password?</a>
                    </div>

                    @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <p class="small text-muted mb-0">
                        Don't have an account?
                        <a href="/register" class="text-primary fw-medium text-decoration-none">Register as Doctor</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center small text-muted mt-4">Free and Open-Source Medical Management System</p>
    </div>
</div>
@endsection
