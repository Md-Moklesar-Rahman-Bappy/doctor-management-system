@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Prescriptions', 'url' => route('prescriptions.index')],
    ['label' => 'Prescription #' . ($prescription->id ?? '')],
];
@endphp

<div class="main-content">
    <!-- Printable Area -->
    <div id="print-area">
        <div class="d-flex justify-content-between align-items-start mb-4" data-aos="fade-down">
            <div>
                <h2 class="fw-bold text-dark mb-1">Prescription #{{ $prescription->id }}</h2>
                <p class="text-muted mb-0">Created: {{ $prescription->created_at->format('F d, Y') }}</p>
            </div>
            <div class="d-flex gap-2 no-print">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i> Print
                </button>
                <a href="{{ route('prescriptions.download', $prescription->id) }}" class="btn btn-secondary">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
                <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="card shadow-sm" data-aos="fade-up">
            <!-- Header -->
                <div class="card-header bg-white border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="fw-bold text-primary mb-0">
                                <i class="fas fa-hospital me-2"></i>Medical Center
                            </h4>
                            <p class="small text-muted mb-0">123 Health Street, Medical District</p>
                            <p class="small text-muted">Phone: (555) 123-4567 | Email: info@medicalcenter.com</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="d-inline-block p-3 bg-light rounded">
                                <div class="fw-semibold">{{ $prescription->doctor->name ?? 'N/A' }}</div>
                                <div class="small text-muted">
                                    @if($prescription->doctor->degrees)
                                        {{ implode(', ', json_decode($prescription->doctor->degrees, true) ?? []) }}
                                    @endif
                                </div>
                                @if($prescription->doctor->license)
                                    <div class="small text-muted">License #: {{ $prescription->doctor->license }}</div>
                                @endif
                                @if($prescription->doctor->phone)
                                    <div class="small text-muted">Phone: {{ $prescription->doctor->phone }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            <div class="card-body">
                <!-- Patient Info -->
                <div class="row g-3 mb-4 p-3 bg-light rounded">
                    <div class="col-md-3">
                        <label class="small text-muted text-uppercase">Unique ID</label>
                        <p class="fw-medium mb-0">{{ $prescription->patient->unique_id ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted text-uppercase">Patient Name</label>
                        <p class="fw-medium mb-0">{{ $prescription->patient->patient_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted text-uppercase">Age</label>
                        <p class="fw-medium mb-0">{{ $prescription->patient->age ?? 'N/A' }} years</p>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted text-uppercase">Sex</label>
                        <p class="fw-medium mb-0">{{ ucfirst($prescription->patient->sex ?? 'N/A') }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted text-uppercase">Date</label>
                        <p class="fw-medium mb-0">{{ $prescription->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Problems -->
                @if($prescription->problems)
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3 border-bottom pb-2">
                            <i class="fas fa-stethoscope text-primary me-2"></i>Diagnoses/Problems
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(json_decode($prescription->problems, true) ?? [] as $problem)
                                <span class="badge bg-primary-subtle text-primary-emphasis p-2">{{ $problem }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Medicines -->
                <div class="mb-4">
                    <h5 class="fw-semibold mb-3 border-bottom pb-2">
                        <i class="fas fa-pills text-primary me-2"></i>Prescribed Medicines
                    </h5>
                    <div class="d-flex flex-column gap-3">
                        @php
                            $meds = json_decode($prescription->medicines, true) ?? [];
                        @endphp
                        @foreach($meds as $index => $med)
                            <div class="card p-3 border-0 shadow-sm bg-white">
                                <div class="row g-2 align-items-center">
                                    <!-- Medicine Name -->
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-pills text-primary"></i>
                                            <div>
                                                <div class="fw-medium">
                                                    {{ $med['name'] ?? 'N/A' }}
                                                    @if(isset($med['generic_name']) && $med['generic_name'])
                                                        ({{ $med['generic_name'] }})
                                                    @endif
                                                </div>
                                                @if(isset($med['strength']) && $med['strength'])
                                                    <div class="small text-muted">{{ $med['strength'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dosage (1+0+1 Style) -->
                                    <div class="col-md-3">
                                        <span class="badge bg-secondary">
                                            {{ $med['dosage'] ?? 'N/A' }}
                                        </span>
                                    </div>

                                    <!-- Duration -->
                                    <div class="col-md-3">
                                        <span class="badge bg-info">
                                            {{ $med['duration'] ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tests -->
                @if($prescription->tests)
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3 border-bottom pb-2">
                            <i class="fas fa-flask text-primary me-2"></i>Recommended Tests
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(json_decode($prescription->tests, true) ?? [] as $test)
                                <span class="badge bg-info-subtle text-info-emphasis p-2">{{ $test }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="card-footer bg-white border-top text-center">
                <p class="small text-muted mb-0">This is a computer-generated prescription. Please consult your doctor for any clarifications.</p>
                <p class="small text-muted mb-0">Generated on {{ now()->format('F d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
