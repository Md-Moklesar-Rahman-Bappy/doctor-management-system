@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Patients', 'url' => route('patients.index')],
    ['label' => $patient->patient_name ?? 'Patient Details'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">{{ $patient->patient_name }}</h3>
        </div>
        <p class="text-muted">Patient details and medical history</p>
    </div>

    <div class="row g-4">
        <!-- Patient Info Card -->
        <div class="col-lg-4" data-aos="fade-right">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="fw-bold text-primary" style="font-size: 1.5rem;">{{ strtoupper(substr($patient->patient_name, 0, 2)) }}</span>
                    </div>
                    <h5 class="fw-bold">{{ $patient->patient_name }}</h5>
                    <p class="text-muted small mb-2">{{ $patient->unique_id }}</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-info-subtle text-info-emphasis">{{ ucfirst($patient->sex) }}</span>
                        <span class="badge bg-secondary-subtle text-secondary-emphasis">Age: {{ $patient->age }}</span>
                    </div>
                    <div class="border-top pt-3">
                        <div class="row g-2 text-start small">
                            <div class="col-6">
                                <span class="text-muted">Date Registered</span>
                            </div>
                            <div class="col-6 text-end">
                                <span class="fw-medium">{{ $patient->date }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-outline-secondary flex-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('prescriptions.create') }}?patient_id={{ $patient->id }}" class="btn btn-sm btn-primary flex-1">
                            <i class="fas fa-file-prescription me-1"></i> New Prescription
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescriptions -->
        <div class="col-lg-8" data-aos="fade-left">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold mb-0">Prescriptions</h5>
                    <span class="badge bg-primary-subtle text-primary-emphasis">{{ $prescriptions->count() }} Total</span>
                </div>
                <div class="card-body p-0">
                    @if($prescriptions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($prescriptions as $prescription)
                                <a href="{{ route('prescriptions.show', $prescription->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium">Prescription #{{ $prescription->id }}</div>
                                        <div class="small text-muted">{{ $prescription->created_at->format('M d, Y') }}</div>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted small"></i>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-prescription text-muted mb-3" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="text-muted mb-0">No prescriptions yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Lab Reports -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold mb-0">Lab Reports</h5>
                    <span class="badge bg-warning-subtle text-warning-emphasis">{{ $labReports->count() }} Total</span>
                </div>
                <div class="card-body p-0">
                    @if($labReports->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($labReports as $report)
                                <a href="{{ route('lab_test_reports.show', $report->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium">{{ $report->test_name }}</div>
                                        <div class="small text-muted">{{ $report->created_at->format('M d, Y') }}</div>
                                    </div>
                                    @if($report->report_image)
                                        <span class="badge bg-success-subtle text-success-emphasis">Has Image</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-vial text-muted mb-3" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="text-muted mb-0">No lab reports yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
