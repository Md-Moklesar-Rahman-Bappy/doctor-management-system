@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Profile', 'url' => route('profile')],
];
@endphp
<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="page-title">User Profile</h2>
        <p class="page-description">Manage your account settings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Profile Info -->
        <div class="lg:col-span-1">
            <x-card>
                <div class="card-body text-center">
                    <!-- Profile Picture -->
                    <div class="relative inline-block mb-4">
                        <div class="w-24 h-24 bg-brand-100 rounded-full flex items-center justify-center mx-auto">
                            <span class="text-brand-600 font-bold text-3xl">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</span>
                        </div>
                        <button class="absolute bottom-0 right-0 w-8 h-8 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 018.07 4h7.86a2 2 0 011.664.89l.812 1.22A2 2 0 0012.07 7H13a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name ?? 'User' }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->email ?? '' }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-50 text-brand-700 mt-3">
                        {{ ucfirst(auth()->user()->role ?? 'User') }}
                    </span>
                </div>
            </x-card>

            <!-- Quick Stats -->
            <x-card class="mt-6">
                <div class="card-header">
                    <h5 class="text-lg font-semibold text-gray-900">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Doctors Managed</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['doctors'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Patients Managed</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['patients'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Prescriptions Created</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['prescriptions'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Right Column - Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <x-card>
                <div class="card-header">
                    <h5 class="text-lg font-semibold text-gray-900">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/profile/update" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="form-label flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Full Name *
                                </label>
                                <input type="text" id="name" name="name" value="{{ auth()->user()->name ?? '' }}"
                                       class="form-input" required>
                            </div>
                            <div>
                                <label for="email" class="form-label flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Email Address *
                                </label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}"
                                       class="form-input" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="phone" class="form-label flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 010 2H5a1 1 0 00-1 1v3M4 11h16M4 15h16M4 19h16"/>
                                    </svg>
                                    Phone Number
                                </label>
                                <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                       class="form-input" placeholder="+1 (555) 123-4567">
                            </div>
                            <div>
                                <label for="date_of_birth" class="form-label flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Date of Birth
                                </label>
                                <div class="relative">
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                           value="{{ auth()->user()->date_of_birth ?? '' }}" class="date-picker">
                                    <div class="date-picker-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </x-card>

            <!-- Change Password -->
            <x-card>
                <div class="card-header">
                    <h5 class="text-lg font-semibold text-gray-900">Change Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/profile/password" class="space-y-5">
                        @csrf
                        <div>
                            <label for="current_password" class="form-label flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Current Password *
                            </label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" required
                                       class="form-input pl-10" placeholder="Enter current password">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="new_password" class="form-label flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 01-2 2m2-2a2 2 0 01-2-2m2 2v1a3 3 0 01-3 3H9a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    New Password *
                                </label>
                                <input type="password" id="new_password" name="new_password" required
                                       class="form-input" placeholder="Minimum 8 characters">
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="form-label flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 01-2 2m2-2a2 2 0 01-2-2m2 2v1a3 3 0 01-3 3H9a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Confirm Password *
                                </label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                                       class="form-input" placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 01-2 2m2-2a2 2 0 01-2-2m2 2v1a3 3 0 01-3 3H9a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </x-card>

            <!-- Notification Preferences -->
            <x-card>
                <div class="card-header">
                    <h5 class="text-lg font-semibold text-gray-900">Notification Preferences</h5>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <x-toggle-switch name="email_notifications" :checked="true" label="Email Notifications"/>
                        <x-toggle-switch name="push_notifications" :checked="false" label="Push Notifications"/>
                        <x-toggle-switch name="sms_notifications" :checked="false" label="SMS Notifications"/>
                    </div>
                </div>
            </x-card>

            <!-- Danger Zone -->
            <x-card>
                <div class="card-header">
                    <h5 class="text-lg font-semibold text-error-700">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <div class="bg-error-50 border border-error-200 rounded-lg p-4">
                        <h6 class="text-sm font-semibold text-error-800">Delete Account</h6>
                        <p class="text-sm text-error-700 mt-1">Once you delete your account, there is no going back. Please be certain.</p>
                        <button onclick="confirmDelete('/profile/delete', 'your account')" class="btn-danger inline-flex items-center gap-2 mt-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Account
                        </button>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
