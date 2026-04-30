@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Reports', 'url' => route('lab_test_reports.index')],
    ['label' => 'Edit Report'],
];
@endphp>

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('lab_test_reports.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h1 class="fw-bold text-dark mb-0">Edit Lab Report</h1>
        </div>
        <p class="text-muted">Update lab test report</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up">
            <form method="POST" action="{{ route('lab_test_reports.update', $report->id) }}" enctype="multipart/form-data" class="d-flex flex-column gap-4">
                @csrf
                @method('PUT')

                <!-- Patient Info (Read-only) -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Patient Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="small text-muted text-uppercase">Unique ID</label>
                                <p class="fw-medium">{{ $report->patient->unique_id ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted text-uppercase">Patient Name</label>
                                <p class="fw-medium">{{ $report->patient->patient_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted text-uppercase">Age</label>
                                <p class="fw-medium">{{ $report->patient->age ?? 'N/A' }} years</p>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted text-uppercase">Sex</label>
                                <p class="fw-medium">{{ ucfirst($report->patient->sex ?? 'N/A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Test Details -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Test Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="test_name" class="form-label fw-medium">Test Name *</label>
                                <input type="text" id="test_name" name="test_name" value="{{ old('test_name', $report->test_name) }}" required
                                       class="form-control">
                                @error('test_name')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="result" class="form-label fw-medium">Result *</label>
                                <input type="text" id="result" name="result" value="{{ old('result', $report->result) }}" required
                                       class="form-control">
                                @error('result')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="normal_range" class="form-label fw-medium">Normal Range</label>
                                <input type="text" id="normal_range" name="normal_range" value="{{ old('normal_range', $report->normal_range) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="unit" class="form-label fw-medium">Unit</label>
                                <input type="text" id="unit" name="unit" value="{{ old('unit', $report->unit) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-medium">Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="normal" {{ old('status', $report->status) == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ old('status', $report->status) == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="low" {{ old('status', $report->status) == 'low' ? 'selected' : '' }}>Low</option>
                                </select>
                            </div>
                        </div>

                        @if($report->report_image)
                            <div class="mb-3">
                                <label class="form-label fw-medium">Current Image</label>
                                <div>
                                    <img src="{{ asset('storage/' . $report->report_image) }}" alt="Report" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            </div>
                        @endif

                        <div>
                            <label for="report_image" class="form-label fw-medium">Update Report Image</label>
                            <input type="file" id="report_image" name="report_image" accept="image/*" class="form-control">
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Leave empty to keep current image</div>
                        </div>

                        <div>
                            <label for="notes" class="form-label fw-medium">Notes</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes', $report->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3">
                    <a href="{{ route('lab_test_reports.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> Update Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
