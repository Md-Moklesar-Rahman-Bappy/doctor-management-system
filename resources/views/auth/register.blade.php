@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Register'],
];
@endphp
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Doctor Registration</h2>
            <p class="text-gray-500 mt-2">Create your account</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/register" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="form-input" placeholder="Dr. John Smith">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="form-input" placeholder="doctor@hospital.com">
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" id="password" name="password" required
                               class="form-input" placeholder="••••••••">
                        <p class="form-help">Minimum 8 characters</p>
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="form-input" placeholder="••••••••">
                    </div>

                    @if($errors->any())
                        <x-alert variant="danger">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    @endif

                    <button type="submit" class="btn-primary w-full">Create Account</button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="/login" class="text-primary-600 hover:text-primary-700 font-medium">Sign In</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-8">Free and Open-Source Medical Management System</p>
    </div>
</div>
@endsection
