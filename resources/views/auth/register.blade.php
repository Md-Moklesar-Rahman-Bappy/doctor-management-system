@extends('layouts.auth')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Register'],
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
                            <div class="col-md-6 d-none d-md-flex align-items-center" style="background: linear-gradient(135deg, #198754 0%, #157347 100%);">
                                <div class="p-5 text-white text-center">
                                    <div class="mb-4">
                                        <div class="rounded-circle bg-white bg-opacity-25 d-inline-flex align-items-center justify-content-center mb-3" style="width: 96px; height: 96px;">
                                            <i class="fas fa-user-plus fa-3x"></i>
                                        </div>
                                        <h3 class="fw-bold mb-2">Join Doctor HMS</h3>
                                        <p class="opacity-75 mb-4">Start managing your medical practice</p>
                                    </div>

                                    <div class="text-start">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="small">Free & Open Source</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="small">Modern & Easy to Use</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="small">Secure & Reliable</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Registration Form -->
                            <div class="col-md-6">
                                <div class="p-4 p-md-5">
                                    <div class="text-center mb-4">
                                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                            <i class="fas fa-user-plus fa-lg text-success"></i>
                                        </div>
                                        <h3 class="fw-bold mb-1">Doctor Registration</h3>
                                        <p class="text-muted small">Create your account to get started</p>
                                    </div>

                                    <form method="POST" action="/register" class="d-flex flex-column gap-3">
                                        @csrf

                                        <div>
                                            <label for="name" class="form-label fw-medium">
                                                <i class="fas fa-user text-muted me-2"></i>Full Name *
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-user text-muted"></i>
                                                </span>
                                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                                       class="form-control border-start-0 @error('name') is-invalid @enderror" placeholder="Dr. John Smith">
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>

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
                                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Minimum 8 characters</div>
                                            @error('password')
                                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password_confirmation" class="form-label fw-medium">
                                                <i class="fas fa-lock text-muted me-2"></i>Confirm Password *
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-lock text-muted"></i>
                                                </span>
                                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                                       class="form-control border-start-0" placeholder="••••••••">
                                            </div>
                                        </div>

                                        @if($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('password'))
                                            <div class="alert alert-danger border-0">
                                                <i class="fas fa-exclamation-circle me-2"></i>
                                                <ul class="mb-0 ps-3">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                                            <i class="fas fa-user-plus me-2"></i>Create Account
                                        </button>
                                    </form>

                                    <div class="text-center mt-4 pt-3 border-top">
                                        <p class="small text-muted mb-0">
                                            Already have an account?
                                            <a href="/login" class="text-primary fw-semibold text-decoration-none">Sign In</a>
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
