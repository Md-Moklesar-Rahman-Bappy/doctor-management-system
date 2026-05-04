@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Prescriptions', 'url' => route('prescriptions.index')],
    ['label' => 'Create Prescription'],
];
@endphp

<div>
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h1 class="fw-bold text-dark mb-0">Create Prescription</h1>
        </div>
        <p class="text-muted">Search or create patient, then add problems, tests, and medicines</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up">
            <form method="POST" action="{{ route('prescriptions.store') }}" id="prescription-form" class="d-flex flex-column gap-4">
                @csrf

                <!-- Doctor Info -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center bg-primary" style="width: 48px; height: 48px;">
                                <i class="fas fa-user-md text-white"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $doctor->name ?? 'No doctor profile' }}</div>
                                <div class="small text-muted">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id ?? '' }}">
                    </div>
                </div>

                <!-- Patient Search & Info -->
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
                                       placeholder="Type patient unique ID (e.g. PAT-12345678)..." autocomplete="off">
                            </div>
                            <input type="hidden" name="patient_id" id="patient-id" value="{{ $selectedPatientId ?? '' }}">
                            <div id="patient-dropdown" class="position-absolute w-100 bg-white border rounded shadow-lg mt-1 d-none" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="new-patient-toggle" class="form-check-input">
                                <label class="form-check-label small" for="new-patient-toggle">Create new patient</label>
                            </div>
                        </div>

                        <!-- Existing Patient Info -->
                        <div id="existing-patient-info" class="{{ $selectedPatientId ? '' : 'd-none' }}">
                            <div class="bg-light rounded p-3">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label class="small text-muted">Unique ID</label>
                                        <p class="fw-medium mb-0" id="info-unique-id">-</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Patient Name</label>
                                        <input type="text" id="info-name" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Age</label>
                                        <input type="text" id="info-age" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">Sex</label>
                                        <input type="text" id="info-sex" class="form-control" readonly>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label fw-medium">Prescription Date *</label>
                                    <input type="date" name="prescription_date" id="prescription-date" class="form-control"
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- New Patient Form -->
                        <div id="new-patient-form" class="d-none">
                            <div class="border rounded p-3 bg-success-subtle border-success">
                                <h6 class="fw-semibold mb-3">New Patient Details</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium">Patient Name</label>
                                        <input type="text" name="new_patient_name" id="new-patient-name" class="form-control" placeholder="Enter patient name">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-medium">Age</label>
                                        <input type="number" name="new_patient_age" id="new-patient-age" class="form-control" placeholder="Age" min="0" max="150">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-medium">Sex</label>
                                        <select name="new_patient_sex" id="new-patient-sex" class="form-select">
                                            <option value="">Select Sex</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-medium">Date</label>
                                        <input type="date" name="new_patient_date" id="new-patient-date" class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
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
                            <div class="input-group mb-2 problem-row">
                                <div class="input-icon-wrapper flex-1">
                                    <input type="text" name="problem[]" class="form-control ps-4"
                                           placeholder="e.g., Fever, Cough, Headache">
                                    <div class="icon"><i class="fas fa-stethoscope"></i></div>
                                </div>
                                <button type="button" class="btn btn-outline-danger" onclick="removeProblem(this)" disabled>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addProblem()">
                            <i class="fas fa-plus me-1"></i> Add Problem
                        </button>
                    </div>
                </div>

                <!-- Tests -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Tests</h5>
                    </div>
                    <div class="card-body">
                        <div id="tests-container">
                            <div class="input-group mb-2 test-row">
                                <div class="input-icon-wrapper flex-1">
                                    <input type="text" name="tests[]" class="form-control ps-4"
                                           placeholder="e.g., Blood Test, X-Ray">
                                    <div class="icon"><i class="fas fa-vial"></i></div>
                                </div>
                                <button type="button" class="btn btn-outline-danger" onclick="removeTest(this)" disabled>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addTest()">
                            <i class="fas fa-plus me-1"></i> Add Test
                        </button>
                    </div>
                </div>

                <!-- Medicines -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Medicines</h5>
                    </div>
                    <div class="card-body">
                        <div id="medicines-container"></div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addMedicineSearch()">
                            <i class="fas fa-plus me-1"></i> Add Medicine
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3" id="action-buttons">
                    <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" id="submit-btn" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        <span id="btn-text">Generate Prescription</span>
                        <span id="btn-spinner" class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                    </button>
                </div>
            </form>

            <!-- Print/Download Options -->
            <div id="print-options" class="d-none mt-4">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                        <h5 class="fw-semibold">Prescription Created Successfully!</h5>
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fas fa-print me-1"></i> Print Prescription
                            </button>
                            <a href="#" id="download-pdf" class="btn btn-secondary">
                                <i class="fas fa-download me-1"></i> Download PDF
                            </a>
                            <button onclick="resetForm()" class="btn btn-outline-secondary">
                                Create New Prescription
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.hover-bg-light:hover { background-color: #f8f9fa; }
.cursor-pointer { cursor: pointer; }
#patient-dropdown { top: 100%; left: 0; right: 0; }
</style>
@endpush

@push('scripts')
<script>
let medicineIndex = 0;
let searchTimeout;
let createdPrescriptionId = null;

document.addEventListener('DOMContentLoaded', function() {
    const patientSearch = document.getElementById('patient-search');
    const patientDropdown = document.getElementById('patient-dropdown');

    if (!patientSearch || !patientDropdown) return;

    // Patient search with live AJAX
    patientSearch.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = this.value.trim();

        if (searchTerm.length < 2) {
            patientDropdown.classList.add('d-none');
            patientDropdown.innerHTML = '';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch('/patients/autocomplete?term=' + encodeURIComponent(searchTerm))
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data && data.data.length > 0) {
                        let html = '';
                        data.data.forEach(p => {
                            html += '<div class="px-3 py-2 hover-bg-light cursor-pointer" onclick="window.selectPatient(this)"' +
                                ' data-id="' + p.id + '"' +
                                ' data-unique-id="' + p.unique_id + '"' +
                                ' data-name="' + p.patient_name.replace(/"/g, '&quot;') + '"' +
                                ' data-age="' + p.age + '"' +
                                ' data-sex="' + p.sex + '">' +
                                '<span class="fw-medium">' + p.unique_id + '</span> - ' + p.patient_name +
                                '<span class="text-muted small ms-2">Age: ' + p.age + ', ' + p.sex + '</span>' +
                                '</div>';
                        });
                        patientDropdown.innerHTML = html;
                        patientDropdown.classList.remove('d-none');
                    } else {
                        patientDropdown.innerHTML = '<div class="px-3 py-2 text-muted">No patients found</div>';
                        patientDropdown.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    console.error('Search error:', err);
                    patientDropdown.innerHTML = '<div class="px-3 py-2 text-muted">Error searching</div>';
                    patientDropdown.classList.remove('d-none');
                });
        }, 300);
    });

    // Close dropdown on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#patient-search') && !e.target.closest('#patient-dropdown')) {
            patientDropdown.classList.add('d-none');
        }
    });

    // New patient toggle
    const newPatientToggle = document.getElementById('new-patient-toggle');
    if (newPatientToggle) {
        newPatientToggle.addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('new-patient-form').classList.remove('d-none');
                document.getElementById('existing-patient-info').classList.add('d-none');
                document.getElementById('patient-id').value = '';
                document.getElementById('patient-search').value = '';
            } else {
                document.getElementById('new-patient-form').classList.add('d-none');
            }
        });
    }
});

// Global function for patient selection
window.selectPatient = function(el) {
    const id = el.getAttribute('data-id');
    const uniqueId = el.getAttribute('data-unique-id');
    const name = el.getAttribute('data-name');
    const age = el.getAttribute('data-age');
    const sex = el.getAttribute('data-sex');
    const dropdown = document.getElementById('patient-dropdown');

    document.getElementById('patient-id').value = id;
    document.getElementById('patient-search').value = uniqueId + ' - ' + name;
    dropdown.classList.add('d-none');
    dropdown.innerHTML = '';

    document.getElementById('new-patient-toggle').checked = false;
    document.getElementById('new-patient-form').classList.add('d-none');

    // Show basic info
    const sexFormatted = sex ? (sex.charAt(0).toUpperCase() + sex.slice(1)) : 'N/A';
    document.getElementById('info-unique-id').textContent = uniqueId;
    document.getElementById('info-name').value = name;
    document.getElementById('info-age').value = age;
    document.getElementById('info-sex').value = sexFormatted;
    document.getElementById('prescription-date').value = '{{ date("Y-m-d") }}';
    document.getElementById('existing-patient-info').classList.remove('d-none');

    // Fetch full details
    fetch('/patients/unique/' + encodeURIComponent(uniqueId))
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showPatientHistory(data.data);
            }
        })
        .catch(err => console.error('Error fetching patient details:', err));
};

function showPatientHistory(p) {
    const infoDiv = document.getElementById('existing-patient-info');
    let historyHtml = '';

    if (p.prescriptions && p.prescriptions.length > 0) {
        historyHtml += '<div class="mt-3"><label class="small text-muted">Prescription History (' + p.prescriptions.length + ')</label>' +
            '<div class="border rounded p-2 bg-white" style="max-height: 150px; overflow-y: auto;">';
        p.prescriptions.slice(0, 5).forEach(pr => {
            const problems = pr.problem ? (typeof pr.problem === 'string' ? JSON.parse(pr.problem) : pr.problem) : [];
            historyHtml += '<div class="small py-1 border-bottom">' +
                '<i class="fas fa-prescription-bottle-alt text-primary me-1"></i>' +
                (pr.prescription_date || 'N/A') + ' - ' + (problems.length > 0 ? problems.join(', ') : 'No problems') +
                '</div>';
        });
        if (p.prescriptions.length > 5) {
            historyHtml += '<div class="small text-muted py-1">...and ' + (p.prescriptions.length - 5) + ' more</div>';
        }
        historyHtml += '</div></div>';
    }

    if (p.lab_test_reports && p.lab_test_reports.length > 0) {
        historyHtml += '<div class="mt-3"><label class="small text-muted">Lab Test Reports (' + p.lab_test_reports.length + ')</label>' +
            '<div class="border rounded p-2 bg-white" style="max-height: 100px; overflow-y: auto;">';
        p.lab_test_reports.slice(0, 3).forEach(lr => {
            historyHtml += '<div class="small py-1 border-bottom">' +
                '<i class="fas fa-vial text-info me-1"></i>' +
                (lr.test_name || 'Lab Test') + ' - ' + (lr.date || 'N/A') +
                '</div>';
        });
        if (p.lab_test_reports.length > 3) {
            historyHtml += '<div class="small text-muted py-1">...and ' + (p.lab_test_reports.length - 3) + ' more</div>';
        }
        historyHtml += '</div></div>';
    }

    if (historyHtml) {
        const existingHistory = infoDiv.querySelector('.patient-history');
        if (existingHistory) existingHistory.remove();

        const historyDiv = document.createElement('div');
        historyDiv.className = 'patient-history';
        historyDiv.innerHTML = historyHtml;
        infoDiv.appendChild(historyDiv);
    }
}

// New patient toggle
document.getElementById('new-patient-toggle').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('new-patient-form').classList.remove('d-none');
        document.getElementById('existing-patient-info').classList.add('d-none');
        document.getElementById('patient-id').value = '';
        document.getElementById('patient-search').value = '';
    } else {
        document.getElementById('new-patient-form').classList.add('d-none');
    }
});

// Problem functions
function addProblem() {
    const container = document.getElementById('problems-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2 problem-row';
    div.innerHTML = '<div class="input-icon-wrapper flex-1">' +
        '<input type="text" name="problem[]" class="form-control ps-4" placeholder="e.g., Fever">' +
        '<div class="icon"><i class="fas fa-stethoscope"></i></div>' +
        '</div>' +
        '<button type="button" class="btn btn-outline-danger" onclick="removeProblem(this)">' +
        '<i class="fas fa-times"></i></button>';
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
        row.querySelector('button').disabled = rows.length <= 1;
    });
}

// Test functions
function addTest() {
    const container = document.getElementById('tests-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2 test-row';
    div.innerHTML = '<div class="input-icon-wrapper flex-1">' +
        '<input type="text" name="tests[]" class="form-control ps-4" placeholder="e.g., Blood Test">' +
        '<div class="icon"><i class="fas fa-vial"></i></div>' +
        '</div>' +
        '<button type="button" class="btn btn-outline-danger" onclick="removeTest(this)">' +
        '<i class="fas fa-times"></i></button>';
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
        row.querySelector('button').disabled = rows.length <= 1;
    });
}

// Medicine search functions
function addMedicineSearch() {
    const container = document.getElementById('medicines-container');
    const div = document.createElement('div');
    div.className = 'card mb-2 medicine-search-row';
    div.innerHTML = '<div class="card-body p-3">' +
        '<div class="row g-2 align-items-center">' +
        '<div class="col-md-4">' +
        '<div class="input-group">' +
        '<span class="input-group-text bg-light border-end-0"><i class="fas fa-pills text-muted"></i></span>' +
        '<input type="text" class="form-control border-start-0 medicine-search-input" placeholder="Search brand or generic name..." onkeyup="searchMedicine(this, event)">' +
        '<div class="medicine-dropdown position-absolute start-0 top-100 mt-1 w-100 shadow-lg bg-white rounded-3 border d-none" style="z-index: 1050; max-height: 200px; overflow-y: auto;"></div>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-3"><input type="text" class="form-control medicine-dosage" placeholder="Dosage (e.g. 500mg)"></div>' +
        '<div class="col-md-3"><input type="text" class="form-control medicine-frequency" placeholder="When (e.g. 3x/day)"></div>' +
        '<div class="col-md-2"><input type="text" class="form-control medicine-duration" placeholder="Duration (e.g. 7 days)"></div>' +
        '</div>' +
        '<div class="mt-2 d-flex gap-2 align-items-center">' +
        '<button type="button" class="btn btn-sm btn-primary" onclick="addMedicine(this)"><i class="fas fa-check me-1"></i> Add</button>' +
        '<button type="button" class="btn btn-sm btn-outline-danger" onclick="removeMedicineSearch(this)"><i class="fas fa-times"></i></button>' +
        '</div>' +
        '<div class="selected-medicine mt-2 d-none"><span class="badge bg-success"></span></div>' +
        '<input type="hidden" class="medicine-id" name="medicines[' + medicineIndex + '][id]" value="">' +
        '<input type="hidden" class="medicine-name" name="medicines[' + medicineIndex + '][name]" value="">' +
        '<input type="hidden" class="medicine-dosage-hidden" name="medicines[' + medicineIndex + '][dosage]" value="">' +
        '<input type="hidden" class="medicine-frequency-hidden" name="medicines[' + medicineIndex + '][frequency]" value="">' +
        '<input type="hidden" class="medicine-duration-hidden" name="medicines[' + medicineIndex + '][duration]" value="">' +
        '</div>';
    container.appendChild(div);
    medicineIndex++;
}

function searchMedicine(input, event) {
    if (event.key === 'Enter') return;
    const term = input.value.trim();
    const dropdown = input.parentElement.querySelector('.medicine-dropdown');

    if (term.length < 2) {
        dropdown.classList.add('d-none');
        return;
    }

    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        fetch('/medicines/autocomplete?term=' + encodeURIComponent(term))
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    dropdown.innerHTML = data.data.map(m => {
                        const displayName = m.brand_name + (m.generic_name ? ' (' + m.generic_name + ')' : '') + (m.strength ? ' - ' + m.strength : '');
                        return '<div class="px-3 py-2 hover-bg-light cursor-pointer" onclick="selectMedicine(this, \'' + m.id + '\', \'' + m.brand_name.replace(/'/g, "\\'") + '\', \'' + (m.generic_name || '').replace(/'/g, "\\'") + '\', \'' + (m.strength || '').replace(/'/g, "\\'") + '\')">' +
                            '<div class="fw-medium">' + m.brand_name + '</div>' +
                            (m.generic_name ? '<div class="small text-muted">' + m.generic_name + '</div>' : '') +
                            (m.strength ? '<div class="small text-muted">' + m.strength + '</div>' : '') +
                            '</div>';
                    }).join('');
                    dropdown.classList.remove('d-none');
                } else {
                    dropdown.innerHTML = '<div class="px-3 py-2 text-muted">No medicines found</div>';
                    dropdown.classList.remove('d-none');
                }
            });
    }, 300);
}

function selectMedicine(el, id, brandName, genericName, strength) {
    const row = el.closest('.medicine-search-row');
    const displayName = brandName + (genericName ? ' (' + genericName + ')' : '') + (strength ? ' - ' + strength : '');
    row.querySelector('.medicine-id').value = id;
    row.querySelector('.medicine-name').value = brandName;
    row.querySelector('.selected-medicine span').textContent = displayName;
    row.querySelector('.selected-medicine').classList.remove('d-none');
    row.querySelector('.medicine-search-input').classList.add('d-none');
    row.querySelector('.medicine-dropdown').classList.add('d-none');
}

function addMedicine(button) {
    const row = button.closest('.medicine-search-row');
    const name = row.querySelector('.medicine-name').value;
    const dosage = row.querySelector('.medicine-dosage').value;
    const frequency = row.querySelector('.medicine-frequency').value;
    const duration = row.querySelector('.medicine-duration').value;

    if (!name) {
        alert('Please select a medicine first');
        return;
    }

    row.querySelector('.medicine-dosage-hidden').value = dosage;
    row.querySelector('.medicine-frequency-hidden').value = frequency;
    row.querySelector('.medicine-duration-hidden').value = duration;

    row.querySelector('.medicine-dosage').disabled = true;
    row.querySelector('.medicine-frequency').disabled = true;
    row.querySelector('.medicine-duration').disabled = true;
    button.disabled = true;

    const removeBtn = row.querySelector('.btn-outline-danger');
    removeBtn.onclick = function() { row.remove(); };
}

function removeMedicineSearch(button) {
    button.closest('.medicine-search-row').remove();
}

// Form submission via AJAX
document.getElementById('prescription-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const patientId = document.getElementById('patient-id').value;
    const newPatientName = document.getElementById('new-patient-name').value;

    if (!patientId && !newPatientName) {
        Swal.fire('Error', 'Please select a patient or create a new patient', 'error');
        return;
    }

    const problems = [];
    document.querySelectorAll('.problem-row input[name="problem[]"]').forEach(input => {
        if (input.value.trim()) problems.push(input.value.trim());
    });

    const tests = [];
    document.querySelectorAll('.test-row input[name="tests[]"]').forEach(input => {
        if (input.value.trim()) tests.push(input.value.trim());
    });

    const medicines = [];
    document.querySelectorAll('.medicine-search-row').forEach(row => {
        const name = row.querySelector('.medicine-name').value;
        if (name) {
            medicines.push({
                id: row.querySelector('.medicine-id').value,
                name: name,
                dosage: row.querySelector('.medicine-dosage-hidden').value,
                frequency: row.querySelector('.medicine-frequency-hidden').value,
                duration: row.querySelector('.medicine-duration-hidden').value
            });
        }
    });

    if (medicines.length === 0) {
        Swal.fire('Error', 'Please add at least one medicine', 'error');
        return;
    }

    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    submitBtn.disabled = true;
    btnText.textContent = 'Generating...';
    btnSpinner.classList.remove('d-none');

    const formData = new FormData(this);
    formData.set('problem', JSON.stringify(problems));
    formData.set('tests', JSON.stringify(tests));
    formData.set('medicines', JSON.stringify(medicines));

    fetch('{{ route("prescriptions.store") }}', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            createdPrescriptionId = data.prescription_id;
            document.getElementById('download-pdf').href = '{{ url("prescriptions") }}/' + createdPrescriptionId + '/download';
            document.getElementById('action-buttons').classList.add('d-none');
            document.getElementById('print-options').classList.remove('d-none');
            window.scrollTo({ top: document.getElementById('print-options').offsetTop, behavior: 'smooth' });
        } else {
            Swal.fire('Error', 'Error creating prescription: ' + (data.message || JSON.stringify(data)), 'error');
            submitBtn.disabled = false;
            btnText.textContent = 'Generate Prescription';
            btnSpinner.classList.add('d-none');
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Error creating prescription', 'error');
        submitBtn.disabled = false;
        btnText.textContent = 'Generate Prescription';
        btnSpinner.classList.add('d-none');
    });
});

function resetForm() {
    document.getElementById('prescription-form').reset();
    document.getElementById('patient-id').value = '';
    document.getElementById('patient-search').value = '';
    document.getElementById('existing-patient-info').classList.add('d-none');
    document.getElementById('new-patient-form').classList.add('d-none');
    document.getElementById('new-patient-toggle').checked = false;
    document.getElementById('problems-container').innerHTML = '<div class="input-group mb-2 problem-row">' +
        '<div class="input-icon-wrapper flex-1">' +
        '<input type="text" name="problem[]" class="form-control ps-4" placeholder="e.g., Fever">' +
        '<div class="icon"><i class="fas fa-stethoscope"></i></div>' +
        '</div>' +
        '<button type="button" class="btn btn-outline-danger" onclick="removeProblem(this)" disabled>' +
        '<i class="fas fa-times"></i></button>' +
        '</div>';
    document.getElementById('tests-container').innerHTML = '<div class="input-group mb-2 test-row">' +
        '<div class="input-icon-wrapper flex-1">' +
        '<input type="text" name="tests[]" class="form-control ps-4" placeholder="e.g., Blood Test">' +
        '<div class="icon"><i class="fas fa-vial"></i></div>' +
        '</div>' +
        '<button type="button" class="btn btn-outline-danger" onclick="removeTest(this)" disabled>' +
        '<i class="fas fa-times"></i></button>' +
        '</div>';
    document.getElementById('medicines-container').innerHTML = '';
    medicineIndex = 0;

    document.getElementById('action-buttons').classList.remove('d-none');
    document.getElementById('print-options').classList.add('d-none');

    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endpush
@endsection
