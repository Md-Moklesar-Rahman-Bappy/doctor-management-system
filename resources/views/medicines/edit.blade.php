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
                                <x-input name="brand_name" label="Brand Name" icon="fas fa-pills" required />
                            </div>

                            <div class="col-md-6">
                                <x-input name="generic_name" label="Generic Name" icon="fas fa-capsules" required />
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <x-input name="dosage_type" label="Dosage Type" icon="fas fa-pills" />
                            </div>

                            <div class="col-md-4">
                                <x-input name="strength" label="Strength" icon="fas fa-balance-scale" />
                            </div>

                            <div class="col-md-4">
                                <x-input name="package_mark" label="Package" icon="fas fa-box" />
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <x-input name="company_name" label="Company Name" icon="fas fa-industry" />
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
