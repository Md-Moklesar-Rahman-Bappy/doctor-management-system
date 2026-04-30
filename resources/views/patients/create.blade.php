@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Patients', 'url' => route('patients.index')],
    ['label' => 'Add New Patient'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Add New Patient</h3>
        </div>
        <p class="text-muted">Enter patient details below</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('patients.store') }}" class="d-flex flex-column gap-3">
                        @csrf

                        <div>
                            <label for="patient_name" class="form-label fw-medium">Patient Name *</label>
                            <div class="input-icon-wrapper">
                                <input type="text" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" required
                                       class="form-control ps-4" placeholder="Enter patient name">
                                <div class="icon"><i class="fas fa-user"></i></div>
                            </div>
                            @error('patient_name')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="age" class="form-label fw-medium">Age *</label>
                                <input type="number" id="age" name="age" min="0" max="150" value="{{ old('age') }}" required
                                       class="form-control" placeholder="Age">
                                @error('age')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="sex" class="form-label fw-medium">Sex *</label>
                                <select id="sex" name="sex" required class="form-select">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('sex')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="date" class="form-label fw-medium">Date *</label>
                                <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                                       class="form-control">
                                @error('date')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                            <i class="fas fa-info-circle"></i>
                            <span class="small">Unique ID will be auto-generated: PAT-XXXXXXXX</span>
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Patient
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
