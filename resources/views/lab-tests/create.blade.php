@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Tests', 'url' => route('lab-tests.index')],
    ['label' => 'Add New Test'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('lab-tests.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Add New Lab Test</h3>
        </div>
        <p class="text-muted">Enter test details below</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('lab-tests.store') }}" class="d-flex flex-column gap-3">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <x-input name="department" label="Department" icon="fas fa-hospital" required />
                            </div>

                            <div class="col-md-6">
                                <x-input name="test" label="Test Name" icon="fas fa-flask" required />
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <x-input name="code" label="Code" icon="fas fa-barcode" required />
                            </div>

                            <div class="col-md-4">
                                <x-input name="sample_type" label="Sample Type" icon="fas fa-vial" />
                            </div>

                            <div class="col-md-4">
                                <x-input name="panel" label="Panel" icon="fas fa-layer-group" />
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <x-input name="unit" label="Unit" icon="fas fa-balance-scale" />
                            </div>

                            <div class="col-md-4">
                                <label for="result_type" class="form-label fw-medium d-flex align-items-center gap-2">
                                    <i class="fas fa-poll"></i> Result Type
                                </label>
                                <select id="result_type" name="result_type" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="numeric" {{ old('result_type') == 'numeric' ? 'selected' : '' }}>Numeric</option>
                                    <option value="text" {{ old('result_type') == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="boolean" {{ old('result_type') == 'boolean' ? 'selected' : '' }}>Boolean</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <x-input name="normal_range" label="Normal Range" icon="fas fa-chart-line" />
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <x-input name="normal_range_lower" label="Normal Range Lower" icon="fas fa-arrow-down" type="number" step="0.01" />
                            </div>

                            <div class="col-md-6">
                                <x-input name="normal_range_upper" label="Normal Range Upper" icon="fas fa-arrow-up" type="number" step="0.01" />
                            </div>
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('lab-tests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
