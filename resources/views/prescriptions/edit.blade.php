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
                        <h5 class="card-title fw-semibold mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-stethoscope"></i> Problems
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="problems-container">
                            @if($prescription->problem && count($prescription->problem) > 0)
                                @foreach($prescription->problem as $problem)
                                    <div class="input-group mb-2 problem-row">
                                        <input type="text" name="problem[]" class="form-control"
                                               value="{{ $problem }}" placeholder="e.g., Fever">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeProblem(this)" {{ $loop->first && $loop->count == 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 problem-row">
                                    <input type="text" name="problem[]" class="form-control"
                                               placeholder="e.g., Fever">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeProblem(this)" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addProblem()">
                            <i class="fas fa-plus me-1"></i> Add Problem
                        </button>

                        <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i>Add all problems one by one (optional)</div>
                    </div>
                </div>

                <!-- Tests -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-vial"></i> Tests
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="tests-container">
                            @if($prescription->tests && count($prescription->tests) > 0)
                                @foreach($prescription->tests as $test)
                                    <div class="input-group mb-2 test-row">
                                        <input type="text" name="tests[]" class="form-control"
                                               value="{{ $test }}" placeholder="e.g., Blood Test">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeTest(this)" {{ $loop->first && $loop->count == 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 test-row">
                                    <input type="text" name="tests[]" class="form-control"
                                               placeholder="e.g., Blood Test">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeTest(this)" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addTest()">
                            <i class="fas fa-plus me-1"></i> Add Test
                        </button>

                        <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i>Add recommended tests (optional)</div>
                    </div>
                </div>
                    <div class="card-body">
                        <div id="tests-container">
                            @if($prescription->tests && count($prescription->tests) > 0)
                                @foreach($prescription->tests as $test)
                                    <div class="input-group mb-2 test-row">
                                        <input type="text" name="tests[]" class="form-control"
                                               value="{{ $test }}" placeholder="e.g., Blood Test">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeTest(this)" {{ $loop->first && $loop->count == 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                                @else
                                    <div class="input-group mb-2 test-row">
                                        <input type="text" name="tests[]" class="form-control"
                                               placeholder="e.g., Blood Test">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeTest(this)" disabled>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addTest()">
                            <i class="fas fa-plus me-1"></i> Add Test
                        </button>

                        <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i>Add all tests one by one (optional)</div>
                    </div>
                </div>

                <!-- Medicines -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-pills"></i> Medicines
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="medicines-container">
                            @if($prescription->medicines)
                                @php
                                    $meds = $prescription->medicines ?? [];
                                @endphp
                                @foreach($meds as $index => $med)
                                    <div class="card mb-2 medicine-search-row" data-index="{{ $index }}">
                                        <div class="card-body p-3">
                                            <div class="row g-2 align-items-center">
                                                <!-- Medicine Name -->
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="fas fa-pills text-muted"></i>
                                                        </span>
                                                        <input type="text" class="form-control border-start-0 medicine-search-input"
                                                               value="{{ $med['name'] ?? '' }}" readonly>
                                                    </div>
                                                </div>

                                                <!-- Dosage -->
                                                <div class="col-md-3">
                                                    <div class="d-flex align-items-center border rounded px-2" style="height: 38px;">
                                                        <select class="form-select form-select-sm border-0 bg-transparent text-center px-1 fw-bold medicine-dose-1">
                                                            <option value="0" {{ ($med['dosage'] ?? '') == '0' ? 'selected' : '' }}>0</option>
                                                            <option value="0.5" {{ ($med['dosage'] ?? '') == '0.5' ? 'selected' : '' }}>½</option>
                                                            <option value="1" {{ ($med['dosage'] ?? '') == '1' ? 'selected' : '' }} selected>1</option>
                                                        </select>
                                                        <span class="text-muted">+</span>
                                                        <select class="form-select form-select-sm border-0 bg-transparent text-center px-1 fw-bold medicine-dose-2">
                                                            <option value="0" selected>0</option>
                                                            <option value="0.5">½</option>
                                                            <option value="1">1</option>
                                                        </select>
                                                        <span class="text-muted">+</span>
                                                        <select class="form-select form-select-sm border-0 bg-transparent text-center px-1 fw-bold medicine-dose-3">
                                                            <option value="0" selected>0</option>
                                                            <option value="0.5">½</option>
                                                            <option value="1">1</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Duration -->
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light text-muted">For</span>
                                                        <input type="number" class="form-control medicine-duration-num"
                                                               value="{{ $med['duration'] ?? '7' }}">
                                                        <select class="form-select bg-light fw-bold medicine-duration-unit" style="max-width: 100px;">
                                                            <option value="days" selected>Days</option>
                                                            <option value="months">Months</option>
                                                            <option value="weeks">Weeks</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Remove Button -->
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-outline-danger w-100" onclick="removeMedicineRow(this)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Hidden Inputs -->
                                            <input type="hidden" class="medicine-id" name="medicines[{{ $index }}][id]" value="{{ $med['id'] ?? '' }}">
                                            <input type="hidden" class="medicine-name" name="medicines[{{ $index }}][name]" value="{{ $med['name'] ?? '' }}">
                                            <input type="hidden" class="medicine-dosage-hidden" name="medicines[{{ $index }}][dosage]" value="{{ $med['dosage'] ?? '' }}">
                                            <input type="hidden" class="medicine-duration-hidden" name="medicines[{{ $index }}][duration]" value="{{ $med['duration'] ?? '' }}">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.medicineSearchInstance.addRow({ showDosage: true, showTime: true, showDuration: true })">
                            <i class="fas fa-plus me-1"></i> Add Medicine
                        </button>

                        <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i>Search and add medicines with dosage and duration</div>
                    </div>
                </div>
                    <div class="card-body">
                        <div id="medicines-container">
                            @if($prescription->medicines)
                                @php
                                    $meds = $prescription->medicines ?? [];
                                @endphp
                                @foreach($meds as $index => $med)
                                    <div class="card mb-2 medicine-search-row" data-index="{{ $index }}">
                                        <div class="card-body p-3">
                                            <div class="row g-2 align-items-center">
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="fas fa-pills text-muted"></i>
                                                        </span>
                                                        <input type="text" class="form-control border-start-0 medicine-search-input"
                                                               value="{{ $med['name'] ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control medicine-dosage" value="{{ $med['dosage'] ?? '' }}" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    @if(isset($med['time']))
                                                        @php
                                                            $timeData = $med['time'];
                                                        @endphp
                                                        <div class="small text-muted">
                                                            {{ $timeData['display'] ?? '' }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    @if(isset($med['duration']))
                                                        @php
                                                            $durData = $med['duration'];
                                                        @endphp
                                                        <div class="small text-muted">
                                                            {{ $durData['display'] ?? '' }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="medicine-id" name="medicines[{{ $index }}][id]" value="{{ $med['id'] ?? '' }}">
                                        <input type="hidden" class="medicine-name" name="medicines[{{ $index }}][name]" value="{{ $med['name'] ?? '' }}">
                                        <input type="hidden" class="medicine-dosage-hidden" name="medicines[{{ $index }}][dosage]" value="{{ $med['dosage'] ?? '' }}">
                                        <input type="hidden" class="medicine-time-hidden" name="medicines[{{ $index }}][time]" value="{{ is_string($med['time'] ?? '') ? $med['time'] : json_encode($med['time'] ?? '') }}">
                                        <input type="hidden" class="medicine-duration-hidden" name="medicines[{{ $index }}][duration]" value="{{ is_string($med['duration'] ?? '') ? $med['duration'] : json_encode($med['duration'] ?? '') }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.medicineSearchInstance.addRow({ showDosage: true, showTime: true, showDuration: true })">
                            <i class="fas fa-plus me-1"></i> Add Medicine
                        </button>

                        <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i>Search and add medicines</div>
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

@push('scripts')
<script src="{{ asset('js/medicine-search.js') }}"></script>
<script>
// Initialize MedicineSearch for edit form
window.medicineSearchInstance = new MedicineSearch({
    container: '#medicines-container',
    startIndex: {{ $prescription->medicines ? count($prescription->medicines) : 0 }},
    onSelect: function(row, data) {
        console.log('Medicine added:', data);
    }
});

// Problem functions
function addProblem() {
    const container = document.getElementById('problems-container');

    const div = document.createElement('div');
    div.className = 'input-group mb-2 problem-row';
    div.innerHTML = `
        <input type="text" name="problem[]" class="form-control"
               placeholder="e.g., Fever">
        <button type="button" class="btn btn-outline-danger" onclick="removeProblem(this)">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(div);
    updateProblemButtons();
}

function removeProblem(button) {
    button.closest('.problem-row').remove();
    updateProblemButtons();
}

function updateProblemButtons() {
    const rows = document.querySelectorAll('.problem-row');
    rows.forEach(row => {
        const btn = row.querySelector('button');
        btn.disabled = rows.length <= 1;
    });
}

// Test functions
function addTest() {
    const container = document.getElementById('tests-container');

    const div = document.createElement('div');
    div.className = 'input-group mb-2 test-row';
    div.innerHTML = `
        <input type="text" name="tests[]" class="form-control"
               placeholder="e.g., Blood Test">
        <button type="button" class="btn btn-outline-danger" onclick="removeTest(this)">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(div);
    updateTestButtons();
}

function removeTest(button) {
    button.closest('.test-row').remove();
    updateTestButtons();
}

function updateTestButtons() {
    const rows = document.querySelectorAll('.test-row');
    rows.forEach(row => {
        const btn = row.querySelector('button');
        btn.disabled = rows.length <= 1;
    });
}

// Form submission via AJAX
document.getElementById('prescription-form').addEventListener('submit', function(e) {
    e.preventDefault();

    // Collect problems (optional)
    const problems = [];
    document.querySelectorAll('.problem-row input[name="problem[]"]').forEach(input => {
        if (input.value.trim()) {
            problems.push(input.value.trim());
        }
    });

    // Collect tests (optional)
    const tests = [];
    document.querySelectorAll('.test-search-row').forEach(row => {
        const name = row.querySelector('.test-name')?.value;
        if (name) {
            tests.push({
                id: row.querySelector('.test-id')?.value,
                name: name,
                code: row.querySelector('.test-code')?.value
            });
        }
    });

    // Collect medicines using the reusable module
    const medicines = window.medicineSearchInstance.getMedicinesData();

    if (medicines.length === 0) {
        Swal.fire('Error', 'Please add at least one medicine', 'error');
        return;
    }

    const submitBtn = document.querySelector('#prescription-form button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Updating...';

    const formData = new FormData(this);
    formData.set('problem', JSON.stringify(problems));
    formData.set('tests', JSON.stringify(tests));
    formData.set('medicines', JSON.stringify(medicines));

    fetch('{{ route("prescriptions.update", $prescription->id) }}', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success', 'Prescription updated successfully!', 'success');
            setTimeout(() => {
                window.location.href = '{{ route("prescriptions.index") }}';
            }, 1500);
        } else {
            Swal.fire('Error', 'Error updating prescription: ' + (data.message || 'Unknown error'), 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Error updating prescription', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
@endpush
@endsection
