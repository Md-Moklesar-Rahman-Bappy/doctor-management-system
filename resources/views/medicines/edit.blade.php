@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Medicines', 'url' => route('medicines.index')],
    ['label' => 'Edit Medicine'],
];
@endphp>

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Edit Medicine</h3>
        </div>
        <p class="text-muted">Update medicine details</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('medicines.update', $medicine->id) }}" class="d-flex flex-column gap-3">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="brand_name" class="form-label fw-medium">Brand Name *</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" id="brand_name" name="brand_name" value="{{ old('brand_name', $medicine->brand_name) }}" required
                                           class="form-control ps-4">
                                    <div class="icon"><i class="fas fa-pills"></i></div>
                                </div>
                                @error('brand_name')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="generic_name" class="form-label fw-medium">Generic Name *</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" id="generic_name" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}" required
                                           class="form-control ps-4">
                                    <div class="icon"><i class="fas fa-capsules"></i></div>
                                </div>
                                @error('generic_name')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="dosage_type" class="form-label fw-medium">Dosage Type</label>
                                <input type="text" id="dosage_type" name="dosage_type" value="{{ old('dosage_type', $medicine->dosage_type) }}"
                                       class="form-control" placeholder="e.g. Tablet, Syrup">
                            </div>

                            <div class="col-md-4">
                                <label for="strength" class="form-label fw-medium">Strength</label>
                                <input type="text" id="strength" name="strength" value="{{ old('strength', $medicine->strength) }}"
                                       class="form-control" placeholder="e.g. 500mg">
                            </div>

                            <div class="col-md-4">
                                <label for="package_mark" class="form-label fw-medium">Package</label>
                                <input type="text" id="package_mark" name="package_mark" value="{{ old('package_mark', $medicine->package_mark) }}"
                                       class="form-control" placeholder="e.g. 10 tabs">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="company_name" class="form-label fw-medium">Company Name</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $medicine->company_name) }}"
                                           class="form-control ps-4">
                                    <div class="icon"><i class="fas fa-industry"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('medicines.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Medicine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
