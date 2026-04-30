@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Prescriptions', 'url' => route('prescriptions.index')],
    ['label' => 'Edit Prescription'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h1 class="fw-bold text-dark mb-0">Edit Prescription #{{ $prescription->id }}</h1>
        </div>
        <p class="text-muted">Update prescription details</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up">
            <form method="POST" action="{{ route('prescriptions.update', $prescription->id) }}" id="prescription-form" class="d-flex flex-column gap-4">
                @csrf
                @method('PUT')

                <!-- Doctor Info -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center bg-primary" style="width: 48px; height: 48px;">
                                <i class="fas fa-user-md text-white"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $prescription->doctor->name ?? 'N/A' }}</div>
                                <div class="small text-muted">{{ $prescription->doctor->email ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Patient Info (Read-only) -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Patient Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="small text-muted">Unique ID</label>
                                <p class="fw-medium mb-0">{{ $prescription->patient->unique_id ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted">Patient Name</label>
                                <p class="fw-medium mb-0">{{ $prescription->patient->patient_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted">Age</label>
                                <p class="fw-medium mb-0">{{ $prescription->patient->age ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted">Sex</label>
                                <p class="fw-medium mb-0">{{ ucfirst($prescription->patient->sex ?? 'N/A') }}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-medium">Prescription Date</label>
                            <input type="date" name="prescription_date" class="form-control" style="max-width: 300px;"
                                   value="{{ $prescription->prescription_date ?? $prescription->created_at->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <!-- Problems -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Problems</h5>
                    </div>
                    <div class="card-body">
                        <div id="problems-container">
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" class="form-control problem-search flex-1" placeholder="Type to search problems...">
                                <button type="button" class="btn btn-primary" onclick="addProblem(this)">Add</button>
                            </div>
                            <div id="selected-problems"></div>
                        </div>
                        <input type="hidden" name="problems[]" id="problems-json" value="{{ $prescription->problems }}">
                    </div>
                </div>

                <!-- Medicines -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Medicines</h5>
                    </div>
                    <div class="card-body">
                        <div id="medicines-container">
                            @if(isset($prescription->medicines))
                                @php
                                    $meds = json_decode($prescription->medicines, true) ?? [];
                                @endphp
                                @foreach($meds as $index => $med)
                                    <div class="row g-2 mb-2 medicine-row align-items-center">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="medicines[{{ $index }}][name]" value="{{ $med['name'] ?? '' }}" placeholder="Medicine name">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="medicines[{{ $index }}][dosage]" value="{{ $med['dosage'] ?? '' }}" placeholder="Dosage">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="medicines[{{ $index }}][frequency]" value="{{ $med['frequency'] ?? '' }}" placeholder="Frequency">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMedicine(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addMedicine()">
                            <i class="fas fa-plus me-1"></i> Add Medicine
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3">
                    <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Prescription
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
