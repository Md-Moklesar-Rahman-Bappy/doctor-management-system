@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Tests', 'url' => route('lab_tests.index')],
    ['label' => $test->test ?? 'Test Details'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('lab_tests.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">{{ $test->test }}</h3>
        </div>
        <p class="text-muted">Test details and information</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4" data-aos="fade-right">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-flask fa-2x text-info"></i>
                    </div>
                    <h5 class="fw-bold">{{ $test->test }}</h5>
                    <p class="text-muted small">{{ $test->code }}</p>
                    <span class="badge bg-primary-subtle text-primary-emphasis">{{ $test->department }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8" data-aos="fade-left">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Test Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Department</label>
                            <p class="fw-medium">{{ $test->department }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase">Test Name</label>
                            <p class="fw-medium">{{ $test->test }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Code</label>
                            <p class="fw-medium font-monospace">{{ $test->code }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Sample Type</label>
                            <p class="fw-medium">{{ $test->sample_type ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Panel</label>
                            <p class="fw-medium">{{ $test->panel ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Unit</label>
                            <p class="fw-medium">{{ $test->unit ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Result Type</label>
                            <p class="fw-medium">{{ ucfirst($test->result_type ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Normal Range</label>
                            <p class="fw-medium">
                                @if($test->normal_range)
                                    {{ $test->normal_range }}
                                @elseif($test->normal_range_lower && $test->normal_range_upper)
                                    {{ $test->normal_range_lower }} - {{ $test->normal_range_upper }}
                                @elseif($test->normal_range_lower)
                                    > {{ $test->normal_range_lower }}
                                @elseif($test->normal_range_upper)
                                    < {{ $test->normal_range_upper }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top d-flex gap-2">
                    <a href="{{ route('lab_tests.edit', $test->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('lab_tests.destroy', $test->id) }}" class="d-inline">
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
