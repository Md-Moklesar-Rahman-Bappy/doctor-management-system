@extends('layouts.auth')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Login'],
];
@endphp

<div class="min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card border-0 shadow-lg" data-aos="fade-up">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Left Side - Branding -->
                            <div class="col-md-6 d-none d-md-flex align-items-center" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);">
                                <div class="p-5 text-white text-center">
                                    <div class="mb-4">
                                        <div class="rounded-circle bg-white bg-opacity-25 d-inline-flex align-items-center justify-content-center mb-3" style="width: 96px; height: 96px;">
                                            <i class="fas fa-user-md fa-3x"></i>
                                        </div>
                                        <h3 class="fw-bold mb-2">Doctor HMS</h3>
                                        <p class="opacity-75 mb-4">Modern Healthcare Management System</p>
                                    </div>

                                    <div class="text-start">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="small">Manage Patients & Prescriptions</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="small">Lab Tests & Reports</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="small">Medicine Inventory</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Login Form -->
                            <div class="col-md-6">
                                <div class="p-4 p-md-5">
                                    <div class="text-center mb-4">
                                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                            <i class="fas fa-sign-in-alt fa-lg text-primary"></i>
                                        </div>
                                        <h3 class="fw-bold mb-1">Welcome Back</h3>
                                        <p class="text-muted small">Sign in to your account</p>
                                    </div>

                                    <form method="POST" action="/login" class="d-flex flex-column gap-3">
                                        @csrf

                                        <div>
                                            <label for="email" class="form-label fw-medium">
                                                <i class="fas fa-envelope text-muted me-2"></i>Email Address *
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-envelope text-muted"></i>
                                                </span>
                                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                                       class="form-control border-start-0 @error('email') is-invalid @enderror" placeholder="doctor@hospital.com">
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password" class="form-label fw-medium">
                                                <i class="fas fa-lock text-muted me-2"></i>Password *
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-lock text-muted"></i>
                                                </span>
                                                <input type="password" id="password" name="password" required
                                                       class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="••••••••">
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
                                            <div class="alert alert-danger border-0">
                                                <i class="fas fa-exclamation-circle me-2"></i>
                                                <ul class="mb-0 ps-3">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                        </button>
                                    </form>

                                    <div class="text-center mt-4 pt-3 border-top">
                                        <p class="small text-muted mb-0">
                                            Don't have an account?
                                            <a href="/register" class="text-primary fw-semibold text-decoration-none">Register as Doctor</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center small text-muted mt-4 mb-0">Free and Open-Source Medical Management System</p>
            </div>
        </div>
    </div>
</div>
@endsection
