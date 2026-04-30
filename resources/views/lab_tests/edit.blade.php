@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Tests', 'url' => route('lab_tests.index')],
    ['label' => 'Edit Test'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('lab_tests.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">Edit Lab Test</h3>
        </div>
        <p class="text-muted">Update test details</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('lab_tests.update', $test->id) }}" class="d-flex flex-column gap-3">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="department" class="form-label fw-medium">Department *</label>
                                <input type="text" id="department" name="department" value="{{ old('department', $test->department) }}" required
                                       class="form-control">
                                @error('department')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="test" class="form-label fw-medium">Test Name *</label>
                                <input type="text" id="test" name="test" value="{{ old('test', $test->test) }}" required
                                       class="form-control">
                                @error('test')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="code" class="form-label fw-medium">Code *</label>
                                <input type="text" id="code" name="code" value="{{ old('code', $test->code) }}" required
                                       class="form-control font-monospace">
                                @error('code')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="sample_type" class="form-label fw-medium">Sample Type</label>
                                <input type="text" id="sample_type" name="sample_type" value="{{ old('sample_type', $test->sample_type) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="panel" class="form-label fw-medium">Panel</label>
                                <input type="text" id="panel" name="panel" value="{{ old('panel', $test->panel) }}"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="unit" class="form-label fw-medium">Unit</label>
                                <input type="text" id="unit" name="unit" value="{{ old('unit', $test->unit) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="result_type" class="form-label fw-medium">Result Type</label>
                                <select id="result_type" name="result_type" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="numeric" {{ old('result_type', $test->result_type) == 'numeric' ? 'selected' : '' }}>Numeric</option>
                                    <option value="text" {{ old('result_type', $test->result_type) == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="boolean" {{ old('result_type', $test->result_type) == 'boolean' ? 'selected' : '' }}>Boolean</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="normal_range" class="form-label fw-medium">Normal Range</label>
                                <input type="text" id="normal_range" name="normal_range" value="{{ old('normal_range', $test->normal_range) }}"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="normal_range_lower" class="form-label fw-medium">Normal Range Lower</label>
                                <input type="number" step="0.01" id="normal_range_lower" name="normal_range_lower"
                                       value="{{ old('normal_range_lower', $test->normal_range_lower) }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="normal_range_upper" class="form-label fw-medium">Normal Range Upper</label>
                                <input type="number" step="0.01" id="normal_range_upper" name="normal_range_upper"
                                       value="{{ old('normal_range_upper', $test->normal_range_upper) }}" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex gap-3 pt-3 border-top">
                            <a href="{{ route('lab_tests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
