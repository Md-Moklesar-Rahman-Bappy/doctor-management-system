@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Diagnoses', 'url' => route('problems.index')],
    ['label' => 'Add New Diagnosis'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('problems.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Add New Diagnosis</h3>
        </div>
        <p class="text-muted">Enter diagnosis details below</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('problems.store') }}" class="d-flex flex-column gap-3">
                        @csrf

                        <x-input name="name" label="Diagnosis Name" icon="fas fa-stethoscope" required />

                        <div class="mb-3">
                            <label for="description" class="form-label fw-medium d-flex align-items-center gap-2">
                                <i class="fas fa-align-left"></i> Description
                            </label>
                            <textarea id="description" name="description" class="form-control"
                                      rows="4" placeholder="Enter description (optional)">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('problems.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Diagnosis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
