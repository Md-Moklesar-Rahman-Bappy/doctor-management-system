@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Diagnoses', 'url' => route('problems.index')],
    ['label' => $problem->name ?? 'Diagnosis Details'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('problems.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">{{ $problem->name }}</h3>
        </div>
        <p class="text-muted">Diagnosis details and information</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4" data-aos="fade-right">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-stethoscope fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">{{ $problem->name }}</h5>
                    <span class="badge bg-info-subtle text-info-emphasis">Active</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8" data-aos="fade-left">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Diagnosis Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Name</label>
                            <p class="fw-medium">{{ $problem->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Created</label>
                            <p class="fw-medium">{{ $problem->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @if($problem->description)
                        <div class="mt-3 pt-3 border-top">
                            <label class="small text-muted text-uppercase">Description</label>
                            <p class="mb-0">{{ $problem->description }}</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-top d-flex gap-2">
                    <a href="{{ route('problems.edit', $problem->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('problems.destroy', $problem->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
