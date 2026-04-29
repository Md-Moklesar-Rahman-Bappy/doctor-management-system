@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Login'],
];
@endphp
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl border border-secondary-200 shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-secondary-900">Welcome Back</h2>
                <p class="text-secondary-500 mt-1">Sign in to your account</p>
            </div>

            <form method="POST" action="/login" class="space-y-5">
                @csrf

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
                    Sign In
                </x-button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-secondary-600">
                    Don't have an account?
                    <a href="/register" class="text-primary-600 hover:text-primary-700 font-medium">
                        Register as Doctor
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
