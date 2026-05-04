@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Patients', 'url' => route('patients.index')],
    ['label' => 'Edit Patient'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Edit Patient</h3>
        </div>
        <p class="text-muted">Update patient details</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('patients.update', $patient->id) }}" class="d-flex flex-column gap-3">
                        @csrf
                        @method('PUT')

                        <x-input name="patient_name" label="Patient Name" icon="fas fa-user" required />

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="unique_id" class="form-label fw-medium d-flex align-items-center gap-2">
                                    <i class="fas fa-id-card"></i> Unique ID
                                </label>
                                <input type="text" id="unique_id" value="{{ $patient->unique_id }}" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <x-input name="age" label="Age" icon="fas fa-birthday-cake" type="number" min="0" max="150" required />
                            </div>

                            <div class="col-md-4">
                                <label for="sex" class="form-label fw-medium d-flex align-items-center gap-2">
                                    <i class="fas fa-venus-mars"></i> Sex <span class="text-danger">*</span>
                                </label>
                                <select id="sex" name="sex" required class="form-select">
                                    <option value="male" {{ $patient->sex == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $patient->sex == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('sex')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <x-input name="date" label="Date" icon="fas fa-calendar" type="date" required />

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Patient
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
