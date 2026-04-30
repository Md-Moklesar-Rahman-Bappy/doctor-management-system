@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Register'],
];
@endphp

<div class="min-vh-80 d-flex align-items-center justify-content-center">
    <div class="w-100" style="max-width: 400px;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-primary rounded-3" style="width: 64px; height: 64px;">
                <i class="fas fa-user-plus fa-2x text-white"></i>
            </div>
            <h2 class="fw-bold text-dark">Doctor Registration</h2>
            <p class="text-muted">Create your account</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="/register" class="d-flex flex-column gap-3">
                    @csrf

                    <div>
                        <label for="name" class="form-label fw-medium">
                            <i class="fas fa-user text-muted me-2"></i>Full Name *
                        </label>
                        <div class="input-icon-wrapper">
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="form-control ps-4" placeholder="Dr. John Smith">
                            <div class="icon"><i class="fas fa-user"></i></div>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

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
                        <div class="form-text"><i class="fas fa-info-circle me-1"></i>Minimum 8 characters</div>
                        @error('password')
                            <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-label fw-medium">
                            <i class="fas fa-lock text-muted me-2"></i>Confirm Password *
                        </label>
                        <div class="input-icon-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="form-control ps-4" placeholder="••••••••">
                            <div class="icon"><i class="fas fa-lock"></i></div>
                        </div>
                    </div>

                    @if($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('password'))
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
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <p class="small text-muted mb-0">
                        Already have an account?
                        <a href="/login" class="text-primary fw-medium text-decoration-none">Sign In</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center small text-muted mt-4">Free and Open-Source Medical Management System</p>
    </div>
</div>
@endsection
