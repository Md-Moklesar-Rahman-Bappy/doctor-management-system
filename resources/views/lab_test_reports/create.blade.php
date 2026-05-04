@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Lab Reports', 'url' => route('lab_test_reports.index')],
    ['label' => 'Add Lab Report'],
];
@endphp>

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('lab_test_reports.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h1 class="fw-bold text-dark mb-0">Add Lab Report</h1>
        </div>
        <p class="text-muted">Create a new lab test report for a patient</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up">
            <form method="POST" action="{{ route('lab_test_reports.store') }}" enctype="multipart/form-data" class="d-flex flex-column gap-4">
                @csrf

                <!-- Patient Search -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Patient Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-medium">Search Patient by ID *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="patient-search" class="form-control border-start-0"
                                       placeholder="Type patient unique ID..." autocomplete="off">
                            </div>
                            <input type="hidden" name="patient_id" id="patient-id" value="{{ $selectedPatientId ?? '' }}">
                            <div id="patient-dropdown" class="position-absolute w-100 bg-white border rounded shadow-lg mt-1 d-none" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></div>
                        </div>

                        <div id="selected-patient-info" class="{{ $selectedPatientId ? '' : 'd-none' }}">
                            <div class="bg-light rounded p-3">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label class="small text-muted">Unique ID</label>
                                        <p class="fw-medium mb-0" id="info-unique-id">{{ $selectedPatient->unique_id ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Patient Name</label>
                                        <input type="text" id="info-name" class="form-control" value="{{ $selectedPatient->patient_name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Age</label>
                                        <input type="text" id="info-age" class="form-control" value="{{ $selectedPatient->age ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Sex</label>
                                        <input type="text" id="info-sex" class="form-control" value="{{ $selectedPatient->sex ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label fw-medium">Date *</label>
                                    <input type="date" name="date" id="report-date" class="form-control"
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
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
                                <input type="text" id="test_name" name="test_name" value="{{ old('test_name') }}" required
                                       class="form-control" placeholder="e.g. Blood Sugar">
                                @error('test_name')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="result" class="form-label fw-medium">Result *</label>
                                <input type="text" id="result" name="result" value="{{ old('result') }}" required
                                       class="form-control" placeholder="e.g. 95 mg/dL">
                                @error('result')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="normal_range" class="form-label fw-medium">Normal Range</label>
                                <input type="text" id="normal_range" name="normal_range" value="{{ old('normal_range') }}"
                                       class="form-control" placeholder="e.g. 70-110">
                            </div>
                            <div class="col-md-4">
                                <label for="unit" class="form-label fw-medium">Unit</label>
                                <input type="text" id="unit" name="unit" value="{{ old('unit') }}"
                                       class="form-control" placeholder="e.g. mg/dL">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-medium">Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="normal" {{ old('status') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ old('status') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="low" {{ old('status') == 'low' ? 'selected' : '' }}>Low</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="report_image" class="form-label fw-medium">Report Image</label>
                            <input type="file" id="report_image" name="report_image" accept="image/*" class="form-control">
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Upload test report image (optional)</div>
                        </div>

                        <div>
                            <label for="notes" class="form-label fw-medium">Notes</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3">
                    <a href="{{ route('lab_test_reports.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-vial me-1"></i> Save Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let searchTimeout;
const patientUniqueRouteTemplate = '{{ route("patients.byUniqueId", ["uniqueId" => "PLACEHOLDER"]) }}';

document.getElementById('patient-search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const searchTerm = this.value.trim();
    const dropdown = document.getElementById('patient-dropdown');

    if (searchTerm.length < 2) {
        dropdown.classList.add('d-none');
        dropdown.innerHTML = '';
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch('{{ route("patients.autocomplete") }}?term=' + encodeURIComponent(searchTerm))
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                    dropdown.innerHTML = data.data.map(p => {
                        return '<div class="px-3 py-2 hover-bg-light cursor-pointer" data-id="' + p.id + '" data-unique-id="' + p.unique_id + '" data-name="' + p.patient_name.replace(/"/g, '&quot;') + '" data-age="' + (p.age || 'N/A') + '" data-sex="' + (p.sex || 'N/A') + '">' +
                            '<span class="fw-medium">' + p.unique_id + '</span> - ' + p.patient_name +
                            '<span class="text-muted small ms-2">Age: ' + (p.age || 'N/A') + ', ' + (p.sex || 'N/A') + '</span>' +
                            '</div>';
                    }).join('');
                    dropdown.classList.remove('d-none');
                } else {
                    dropdown.innerHTML = '<div class="px-3 py-2 text-muted">No patients found</div>';
                    dropdown.classList.remove('d-none');
                }
            })
            .catch(err => {
                console.error('Search error:', err);
                dropdown.innerHTML = '<div class="px-3 py-2 text-muted">Error searching</div>';
                dropdown.classList.remove('d-none');
            });
    }, 300);
});

// Handle dropdown item click using event delegation
document.getElementById('patient-dropdown').addEventListener('click', function(e) {
    const item = e.target.closest('[data-id]');
    if (!item) return;

    const id = item.getAttribute('data-id');
    const uniqueId = item.getAttribute('data-unique-id');
    const name = item.getAttribute('data-name');
    const age = item.getAttribute('data-age');
    const sex = item.getAttribute('data-sex');

    selectPatient(parseInt(id), uniqueId, name, age, sex);
});

function selectPatient(id, uniqueId, patientName, age, sex) {
    document.getElementById('patient-id').value = id;
    document.getElementById('patient-search').value = uniqueId + ' - ' + patientName;
    document.getElementById('patient-dropdown').classList.add('d-none');
    document.getElementById('patient-dropdown').innerHTML = '';

    const sexFormatted = sex ? (sex.charAt(0).toUpperCase() + sex.slice(1)) : 'N/A';

    document.getElementById('info-unique-id').textContent = uniqueId || 'N/A';
    document.getElementById('info-name').value = patientName || 'N/A';
    document.getElementById('info-age').value = age || 'N/A';
    document.getElementById('info-sex').value = sexFormatted;
    document.getElementById('report-date').value = new Date().toISOString().split('T')[0];
    document.getElementById('selected-patient-info').classList.remove('d-none');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#patient-search') && !e.target.closest('#patient-dropdown')) {
        document.getElementById('patient-dropdown').classList.add('d-none');
    }
});
</script>
@endpush
@endsection
