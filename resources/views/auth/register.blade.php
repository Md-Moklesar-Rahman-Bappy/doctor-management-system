@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Register'],
];
@endphp
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl border border-secondary-200 shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-secondary-900">Doctor Registration</h2>
                <p class="text-secondary-500 mt-1">Create your account</p>
            </div>

            <form method="POST" action="/register" class="space-y-5">
                @csrf

                <x-input
                    type="text"
                    name="name"
                    label="Full Name"
                    placeholder="Dr. John Smith"
                    required
                    :value="old('name')"
                />

                <x-input
                    type="email"
                    name="email"
                    label="Email Address"
                    placeholder="doctor@hospital.com"
                    required
                    :value="old('email')"
                />

                <x-input
                    type="password"
                    name="password"
                    label="Password"
                    placeholder="••••••••"
                    required
                    help="Minimum 8 characters"
                />

                <x-input
                    type="password"
                    name="password_confirmation"
                    label="Confirm Password"
                    placeholder="••••••••"
                    required
                />

                @if($errors->any())
                    <x-alert variant="danger">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                @endif

                <x-button type="submit" variant="primary" fullWidth="true" size="lg">
                    Create Account
                </x-button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-secondary-600">
                    Already have an account?
                    <a href="/login" class="text-primary-600 hover:text-primary-700 font-medium">
                        Sign In
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
