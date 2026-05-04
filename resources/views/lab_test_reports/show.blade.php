@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Reports', 'url' => route('lab_test_reports.index')],
    ['label' => 'Report #' . ($report->id ?? '')],
];
@endphp>

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('lab_test_reports.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h1 class="fw-bold text-dark mb-0">Lab Report #{{ $report->id }}</h1>
        </div>
        <p class="text-muted">Test report details</p>
    </div>

    <div class="row g-4">
        <!-- Patient Info -->
        <div class="col-lg-4" data-aos="fade-right">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <span class="fw-bold text-primary" style="font-size: 1.25rem;">{{ strtoupper(substr($report->patient->patient_name ?? 'P', 0, 2)) }}</span>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $report->patient->patient_name ?? 'N/A' }}</h5>
                            <p class="text-muted small mb-0">{{ $report->patient->unique_id ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-info-subtle text-info-emphasis">{{ ucfirst($report->patient->sex ?? 'N/A') }}</span>
                        <span class="badge bg-secondary-subtle text-secondary-emphasis">Age: {{ $report->patient->age ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Details -->
        <div class="col-lg-8" data-aos="fade-left">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold mb-0">Test: {{ $report->test_name }}</h5>
                    <span class="badge {{ $report->status == 'normal' ? 'bg-success' : ($report->status == 'high' ? 'bg-danger' : 'bg-warning') }}">
                        {{ ucfirst($report->status ?? 'normal') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Test Name</label>
                            <p class="fw-medium">{{ $report->test_name }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Result</label>
                            <p class="fw-bold h4 {{ $report->status == 'normal' ? 'text-success' : ($report->status == 'high' ? 'text-danger' : 'text-warning') }}">
                                {{ $report->result }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Normal Range</label>
                            <p class="fw-medium">{{ $report->normal_range ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Unit</label>
                            <p class="fw-medium">{{ $report->unit ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-muted text-uppercase">Date</label>
                            <p class="fw-medium">{{ $report->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($report->notes)
                        <div class="border-top pt-3">
                            <label class="small text-muted text-uppercase">Notes</label>
                            <p class="mb-0">{{ $report->notes }}</p>
                        </div>
                    @endif

                    @if($report->report_image)
                        <div class="border-top pt-3 mt-3">
                            <label class="small text-muted text-uppercase mb-2">Report Image</label>
                            <img src="{{ asset('storage/' . $report->report_image) }}" alt="Report" class="img-fluid rounded">
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-top d-flex gap-2">
                    <a href="{{ route('lab_test_reports.edit', $report->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('lab_test_reports.destroy', $report->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this report?')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
