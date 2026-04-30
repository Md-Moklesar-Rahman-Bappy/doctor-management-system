@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Medicines', 'url' => route('medicines.index')],
    ['label' => $medicine->brand_name ?? 'Medicine Details'],
];
@endphp>

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">{{ $medicine->brand_name }}</h3>
        </div>
        <p class="text-muted">Medicine details and information</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4" data-aos="fade-right">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-pills fa-2x text-white"></i>
                    </div>
                    <h5 class="fw-bold">{{ $medicine->brand_name }}</h5>
                    <p class="text-muted small">{{ $medicine->generic_name }}</p>
                    <span class="badge bg-success-subtle text-success-emphasis">{{ $medicine->dosage_type ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8" data-aos="fade-left">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Medicine Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Brand Name</label>
                            <p class="fw-medium">{{ $medicine->brand_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Generic Name</label>
                            <p class="fw-medium">{{ $medicine->generic_name }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Dosage Type</label>
                            <p class="fw-medium">{{ $medicine->dosage_type ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Strength</label>
                            <p class="fw-medium">{{ $medicine->strength ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Package</label>
                            <p class="fw-medium">{{ $medicine->package_mark ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Company</label>
                            <p class="fw-medium">{{ $medicine->company_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top d-flex gap-2">
                    <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('medicines.destroy', $medicine->id) }}" class="d-inline">
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
