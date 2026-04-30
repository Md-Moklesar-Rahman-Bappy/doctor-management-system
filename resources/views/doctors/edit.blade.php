@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
    ['label' => 'Edit Doctor'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Edit Doctor</h3>
        </div>
        <p class="text-muted">Update doctor details</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('doctors.update', $doctor->id) }}" class="d-flex flex-column gap-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="form-label fw-medium">Full Name *</label>
                            <div class="input-icon-wrapper">
                                <input type="text" id="name" name="name" value="{{ old('name', $doctor->name) }}" required
                                       class="form-control ps-4">
                                <div class="icon"><i class="fas fa-user-md"></i></div>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">Email Address *</label>
                                <div class="input-icon-wrapper">
                                    <input type="email" id="email" name="email" value="{{ old('email', $doctor->email) }}" required
                                           class="form-control ps-4">
                                    <div class="icon"><i class="fas fa-envelope"></i></div>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium">Phone Number</label>
                                <div class="input-icon-wrapper">
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}"
                                           class="form-control ps-4">
                                    <div class="icon"><i class="fas fa-phone"></i></div>
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="degrees" class="form-label fw-medium">Degrees</label>
                            <div class="input-icon-wrapper">
                                <input type="text" id="degrees" name="degrees" value="{{ old('degrees', $doctor->degrees) }}"
                                       class="form-control ps-4" placeholder="MBBS, MD, FRCS">
                                <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                            </div>
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Enter degrees separated by commas</div>
                            @error('degrees')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Doctor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
