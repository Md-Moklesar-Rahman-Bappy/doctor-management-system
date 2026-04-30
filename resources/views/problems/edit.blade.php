@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Diagnoses', 'url' => route('problems.index')],
    ['label' => 'Edit Diagnosis'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('problems.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Edit Diagnosis</h3>
        </div>
        <p class="text-muted">Update diagnosis details</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('problems.update', $problem->id) }}" class="d-flex flex-column gap-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="form-label fw-medium">Diagnosis Name *</label>
                            <div class="input-icon-wrapper">
                                <input type="text" id="name" name="name" value="{{ old('name', $problem->name) }}" required
                                       class="form-control ps-4">
                                <div class="icon"><i class="fas fa-stethoscope"></i></div>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="form-label fw-medium">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $problem->description) }}</textarea>
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('problems.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Diagnosis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
