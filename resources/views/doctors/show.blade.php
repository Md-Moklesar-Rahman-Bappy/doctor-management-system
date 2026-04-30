@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Doctors', 'url' => route('doctors.index')],
    ['label' => $doctor->name ?? 'Doctor Details'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h3 class="fw-bold text-dark mb-0">{{ $doctor->name }}</h3>
        </div>
        <p class="text-muted">Doctor details and profile</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4" data-aos="fade-right">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-md text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold">{{ $doctor->name }}</h5>
                    <p class="text-muted small mb-2">{{ $doctor->email }}</p>
                    @if($doctor->degrees)
                        <div class="d-flex flex-wrap justify-content-center gap-1 mb-3">
                            @foreach(json_decode($doctor->degrees, true) as $degree)
                                <span class="badge bg-info-subtle text-info-emphasis">{{ $degree }}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="border-top pt-3">
                        <div class="row g-2 text-start small">
                            <div class="col-6">
                                <span class="text-muted">Phone</span>
                            </div>
                            <div class="col-6 text-end">
                                <span class="fw-medium">{{ $doctor->phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-outline-secondary flex-1">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8" data-aos="fade-left">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-semibold mb-0">Recent Prescriptions</h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($prescriptions) && $prescriptions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($prescriptions as $prescription)
                                <a href="{{ route('prescriptions.show', $prescription->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium">Prescription #{{ $prescription->id }}</div>
                                        <div class="small text-muted">{{ $prescription->created_at->format('M d, Y') }} - {{ $prescription->patient->patient_name ?? 'N/A' }}</div>
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
        </div>
    </div>
</div>
@endsection
