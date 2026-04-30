@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Profile', 'url' => route('profile')],
];
@endphp

<div>
    <!-- Page Header -->
    <div class="mb-4" data-aos="fade-down">
        <h2 class="page-title">User Profile</h2>
        <p class="page-description">Manage your account settings</p>
    </div>

    <div class="row g-4">
        <!-- Left Column - Profile Info -->
        <div class="col-lg-4" data-aos="fade-right">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <!-- Profile Picture -->
                    <div class="position-relative d-inline-block mb-3">
                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center mx-auto" style="width: 96px; height: 96px;">
                            <span class="text-primary fw-bold" style="font-size: 2rem;">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</span>
                        </div>
                        <button class="position-absolute bottom-0 end-0 w-32 h-32 bg-white border border-2 rounded-circle d-flex align-items-center justify-content-center hover-bg-light">
                            <i class="fas fa-camera text-muted"></i>
                        </button>
                    </div>
                    <h3 class="fw-semibold">{{ auth()->user()->name ?? 'User' }}</h3>
                    <p class="text-muted small">{{ auth()->user()->email ?? '' }}</p>
                    <span class="badge bg-primary-subtle text-primary-emphasis">
                        {{ ucfirst(auth()->user()->role ?? 'User') }}
                    </span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="small text-muted">Doctors Managed</span>
                        <span class="fw-medium">{{ $stats['doctors'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="small text-muted">Patients Managed</span>
                        <span class="fw-medium">{{ $stats['patients'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="small text-muted">Prescriptions Created</span>
                        <span class="fw-medium">{{ $stats['prescriptions'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Forms -->
        <div class="col-lg-8" data-aos="fade-left">
            <!-- Personal Information -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/profile/update" class="d-flex flex-column gap-3">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium">
                                    <i class="fas fa-user text-muted me-2"></i>Full Name *
                                </label>
                                <input type="text" id="name" name="name" value="{{ auth()->user()->name ?? '' }}"
                                       class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">
                                    <i class="fas fa-envelope text-muted me-2"></i>Email Address *
                                </label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}"
                                       class="form-control" required>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium">
                                    <i class="fas fa-phone text-muted me-2"></i>Phone Number
                                </label>
                                <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                       class="form-control" placeholder="+1 (555) 123-4567">
                            </div>
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label fw-medium">
                                    <i class="fas fa-calendar text-muted me-2"></i>Date of Birth
                                </label>
                                <input type="date" id="date_of_birth" name="date_of_birth"
                                       value="{{ auth()->user()->date_of_birth ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-3 border-top">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/profile/password" class="d-flex flex-column gap-3">
                        @csrf
                        <div>
                            <label for="current_password" class="form-label fw-medium">
                                <i class="fas fa-lock text-muted me-2"></i>Current Password *
                            </label>
                            <div class="input-icon-wrapper">
                                <input type="password" id="current_password" name="current_password" required
                                       class="form-control ps-4" placeholder="Enter current password">
                                <div class="icon"><i class="fas fa-lock"></i></div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label fw-medium">
                                    <i class="fas fa-key text-muted me-2"></i>New Password *
                                </label>
                                <input type="password" id="new_password" name="new_password" required
                                       class="form-control" placeholder="Minimum 8 characters">
                            </div>
                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="form-label fw-medium">
                                    <i class="fas fa-key text-muted me-2"></i>Confirm Password *
                                </label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                                       class="form-control" placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-3 border-top">
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="fas fa-key"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification Preferences -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Notification Preferences</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0 fw-medium">Email Notifications</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="email_notifications" checked>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0 fw-medium">Push Notifications</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="push_notifications">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0 fw-medium">SMS Notifications</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="sms_notifications">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card shadow-sm mt-4 border-danger">
                <div class="card-header bg-white border-bottom border-danger">
                    <h5 class="card-title fw-semibold text-danger">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <div class="bg-danger-subtle border border-danger rounded p-3">
                        <h6 class="fw-semibold text-danger-emphasis">Delete Account</h6>
                        <p class="small text-danger-emphasis mb-3">Once you delete your account, there is no going back. Please be certain.</p>
                        <button onclick="confirmDelete('/profile/delete', 'your account')" class="btn btn-danger d-flex align-items-center gap-2">
                            <i class="fas fa-trash"></i> Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
