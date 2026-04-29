@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Login'],
];
@endphp
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
            <p class="text-gray-500 mt-2">Sign in to your account</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/login" class="space-y-5">
                    @csrf

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
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-600">Keep me logged in</span>
                        </label>
                        <a href="#" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Forgot password?</a>
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

                    <button type="submit" class="btn-primary w-full">Sign In</button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="/register" class="text-primary-600 hover:text-primary-700 font-medium">Register as Doctor</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-8">Free and Open-Source Medical Management System</p>
    </div>
</div>
@endsection
