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
                        <div class="mb-3">
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
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" class="form-control problem-search flex-1" placeholder="Type to search problems...">
                                <button type="button" class="btn btn-primary" onclick="addProblem(this)">Add</button>
                            </div>
                            <div id="selected-problems"></div>
                        </div>
                        <input type="hidden" name="problem[]" id="problems-json">
                    </div>
                </div>

                <!-- Tests -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Tests</h5>
                    </div>
                    <div class="card-body">
                        <div id="tests-container">
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" class="form-control test-search flex-1" placeholder="Type to search lab tests...">
                                <button type="button" class="btn btn-primary" onclick="addTest(this)">Add</button>
                            </div>
                            <div id="selected-tests"></div>
                        </div>
                        <input type="hidden" name="tests[]" id="tests-json">
                    </div>
                </div>

                <!-- Medicines -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-semibold mb-0">Medicines</h5>
                    </div>
                    <div class="card-body">
                        <div id="medicines-container">
                            <div class="row g-2 mb-2 medicine-row align-items-center">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="medicines[0][name]" placeholder="Medicine name">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="medicines[0][dosage]" placeholder="Dosage (e.g. 500mg)">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="medicines[0][frequency]" placeholder="Frequency (e.g. 3x/day)">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMedicine(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addMedicine()">
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

@push('scripts')
<script>
let medicineIndex = 1;
let searchTimeout;
let createdPrescriptionId = null;

// Patient search with live AJAX
document.getElementById('patient-search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const searchTerm = this.value;
    const dropdown = document.getElementById('patient-dropdown');

    if (searchTerm.length < 2) {
        dropdown.classList.add('d-none');
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch('{{ route("patients.autocomplete") }}?term=' + encodeURIComponent(searchTerm))
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    dropdown.innerHTML = data.data.map(p => {
                        const encoded = btoa(unescape(encodeURIComponent(JSON.stringify(p))));
                        return '<div class="px-3 py-2 hover-bg-light cursor-pointer" onclick="selectPatient(\'' + encoded + '\')">' +
                            '<span class="fw-medium">' + p.unique_id + '</span> - ' + p.patient_name +
                            '<span class="text-muted small ms-2">Age: ' + p.age + ', ' + p.sex + '</span>' +
                            '</div>';
                    }).join('');
                    dropdown.classList.remove('d-none');
                } else {
                    dropdown.innerHTML = '<div class="px-3 py-2 text-muted">No patients found</div>';
                    dropdown.classList.remove('d-none');
                }
            });
    }, 300);
});

function selectPatient(encodedData) {
    const p = JSON.parse(decodeURIComponent(escape(atob(encodedData))));
    document.getElementById('patient-id').value = p.id;
    document.getElementById('patient-search').value = p.unique_id + ' - ' + p.patient_name;
    document.getElementById('patient-dropdown').classList.add('d-none');

    document.getElementById('info-unique-id').textContent = p.unique_id;
    document.getElementById('info-name').value = p.patient_name;
    document.getElementById('info-age').value = p.age;
    document.getElementById('info-sex').value = p.sex;
    document.getElementById('prescription-date').value = p.date || '{{ date("Y-m-d") }}';
    document.getElementById('existing-patient-info').classList.remove('d-none');

    document.getElementById('new-patient-toggle').checked = false;
    document.getElementById('new-patient-form').classList.add('d-none');
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

// Close dropdown on click outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('#patient-search') && !e.target.closest('#patient-dropdown')) {
        document.getElementById('patient-dropdown').classList.add('d-none');
    }
});

// Medicine functions
function addMedicine() {
    const container = document.getElementById('medicines-container');
    const html = '<div class="row g-2 mb-2 medicine-row align-items-center">' +
        '<div class="col-md-5">' +
            '<input type="text" class="form-control" name="medicines[' + medicineIndex + '][name]" placeholder="Medicine name">' +
        '</div>' +
        '<div class="col-md-3">' +
            '<input type="text" class="form-control" name="medicines[' + medicineIndex + '][dosage]" placeholder="Dosage (e.g. 500mg)">' +
        '</div>' +
        '<div class="col-md-3">' +
            '<input type="text" class="form-control" name="medicines[' + medicineIndex + '][frequency]" placeholder="Frequency (e.g. 3x/day)">' +
        '</div>' +
        '<div class="col-md-1">' +
            '<button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMedicine(this)">' +
                '<i class="fas fa-trash"></i>' +
            '</button>' +
        '</div>' +
    '</div>';
    container.insertAdjacentHTML('beforeend', html);
    medicineIndex++;
}

function removeMedicine(btn) {
    btn.closest('.medicine-row').remove();
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

    const medicines = [];
    document.querySelectorAll('.medicine-row').forEach(row => {
        const nameInput = row.querySelector('input[name*="[name]"]');
        const dosageInput = row.querySelector('input[name*="[dosage]"]');
        const frequencyInput = row.querySelector('input[name*="[frequency]"]');
        if (nameInput && nameInput.value) {
            medicines.push({
                name: nameInput.value,
                dosage: dosageInput ? dosageInput.value : '',
                frequency: frequencyInput ? frequencyInput.value : ''
            });
        }
    });

    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    submitBtn.disabled = true;
    btnText.textContent = 'Generating...';
    btnSpinner.classList.remove('d-none');

    const formData = new FormData(this);
    formData.set('medicines', JSON.stringify(medicines));

    fetch('{{ route("prescriptions.store") }}', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            createdPrescriptionId = data.prescription_id;
            document.getElementById('download-pdf').href = '/prescriptions/' + createdPrescriptionId;
            document.getElementById('action-buttons').classList.add('d-none');
            document.getElementById('print-options').classList.remove('d-none');
            window.scrollTo({ top: document.getElementById('print-options').offsetTop, behavior: 'smooth' });
        } else {
            Swal.fire('Error', 'Error creating prescription: ' + (data.message || 'Unknown error'), 'error');
            submitBtn.disabled = false;
            btnText.textContent = 'Generate Prescription';
            btnSpinner.classList.add('d-none');
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Error creating prescription', 'error');
    });
});

function resetForm() {
    document.getElementById('prescription-form').reset();
    document.getElementById('patient-id').value = '';
    document.getElementById('patient-search').value = '';
    document.getElementById('existing-patient-info').classList.add('d-none');
    document.getElementById('new-patient-form').classList.add('d-none');
    document.getElementById('new-patient-toggle').checked = false;
    document.getElementById('selected-problems').innerHTML = '';
    document.getElementById('selected-tests').innerHTML = '';
    document.getElementById('medicines-container').innerHTML = '<div class="row g-2 mb-2 medicine-row align-items-center">' +
        '<div class="col-md-5">' +
            '<input type="text" class="form-control" name="medicines[0][name]" placeholder="Medicine name">' +
        '</div>' +
        '<div class="col-md-3">' +
            '<input type="text" class="form-control" name="medicines[0][dosage]" placeholder="Dosage (e.g. 500mg)">' +
        '</div>' +
        '<div class="col-md-3">' +
            '<input type="text" class="form-control" name="medicines[0][frequency]" placeholder="Frequency (e.g. 3x/day)">' +
        '</div>' +
        '<div class="col-md-1">' +
            '<button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMedicine(this)">' +
                '<i class="fas fa-trash"></i>' +
            '</button>' +
        '</div>' +
    '</div>';
    medicineIndex = 1;

    document.getElementById('action-buttons').classList.remove('d-none');
    document.getElementById('print-options').classList.add('d-none');

    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endpush
@endsection
