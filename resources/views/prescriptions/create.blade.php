@extends('layouts.dashboard')

@section('content')
@php
$breadcrumbs = [
    ['label' => 'Prescriptions', 'url' => route('prescriptions.index')],
    ['label' => 'Create Prescription'],
];
@endphp
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('prescriptions.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Create Prescription</h1>
        </div>
        <p class="text-gray-500">Search or create patient, then add problems, tests, and medicines</p>
    </div>

    <div class="max-w-5xl">
        <form method="POST" action="{{ route('prescriptions.store') }}" id="prescription-form" class="space-y-6">
            @csrf

            <!-- Doctor Info -->
            <x-card>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-brand-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">{{ $doctor->name ?? 'No doctor profile' }}</div>
                        <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <input type="hidden" name="doctor_id" value="{{ $doctor->id ?? '' }}">
            </x-card>

            <!-- Patient Search & Info -->
            <x-card>
                <h5 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h5>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Patient by ID *</label>
                    <div class="relative">
                        <input type="text" id="patient-search" class="form-input pl-10"
                               placeholder="Type patient unique ID (e.g. PAT-12345678)..." autocomplete="off">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 -trangray-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <div id="patient-dropdown" class="absolute z-10 w-full bg-white border border-gray-200 rounded-lg shadow-lg mt-1 hidden max-h-48 overflow-y-auto"></div>
                    </div>
                    <input type="hidden" name="patient_id" id="patient-id" value="{{ $selectedPatientId ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="new-patient-toggle" class="rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                        <span class="ml-2 text-sm text-gray-600">Create new patient</span>
                    </label>
                </div>

                <!-- Existing Patient Info -->
                <div id="existing-patient-info" class="{{ $selectedPatientId ? '' : 'hidden' }}">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Unique ID</label>
                                <p class="font-medium text-gray-900" id="info-unique-id">-</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Patient Name</label>
                                <input type="text" id="info-name" class="form-input bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Age</label>
                                <input type="text" id="info-age" class="form-input bg-gray-100" readonly>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Sex</label>
                                <input type="text" id="info-sex" class="form-input bg-gray-100" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Prescription Date *</label>
                            <input type="date" name="prescription_date" id="prescription-date" class="form-input"
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <!-- New Patient Form -->
                <div id="new-patient-form" class="hidden">
                    <div class="p-4 bg-success-50 rounded-lg border border-success-200">
                        <h6 class="font-semibold text-gray-700 mb-3">New Patient Details</h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input name="new_patient_name" label="Patient Name" id="new-patient-name" placeholder="Enter patient name" />
                            <x-input name="new_patient_age" label="Age" type="number" id="new-patient-age" placeholder="Age" min="0" max="150" />
                            <x-select name="new_patient_sex" label="Sex" id="new-patient-sex" :options="['male' => 'Male', 'female' => 'Female']" placeholder="Select Sex" />
                            <x-input name="new_patient_date" label="Date" type="date" id="new-patient-date" :value="date('Y-m-d')" />
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Problems -->
            <x-card>
                <h5 class="text-lg font-semibold text-gray-900 mb-4">Problems</h5>
                <div id="problems-container">
                    <div class="flex items-center gap-2 mb-2">
                        <input type="text" class="flex-1 form-input problem-search" placeholder="Type to search problems...">
                        <button type="button" class="btn-primary text-sm px-4 py-2.5" onclick="addProblem(this)">Add</button>
                    </div>
                    <div id="selected-problems"></div>
                </div>
                <input type="hidden" name="problem[]" id="problems-json">
            </x-card>

            <!-- Tests -->
            <x-card>
                <h5 class="text-lg font-semibold text-gray-900 mb-4">Tests</h5>
                <div id="tests-container">
                    <div class="flex items-center gap-2 mb-2">
                        <input type="text" class="flex-1 form-input test-search" placeholder="Type to search lab tests...">
                        <button type="button" class="btn-primary text-sm px-4 py-2.5" onclick="addTest(this)">Add</button>
                    </div>
                    <div id="selected-tests"></div>
                </div>
                <input type="hidden" name="tests[]" id="tests-json">
            </x-card>

            <!-- Medicines -->
            <x-card>
                <h5 class="text-lg font-semibold text-gray-900 mb-4">Medicines</h5>
                <div id="medicines-container">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 mb-2 medicine-row items-center">
                        <div class="md:col-span-5">
                            <input type="text" class="w-full form-input" name="medicines[0][name]" placeholder="Medicine name">
                        </div>
                        <div class="md:col-span-3">
                            <input type="text" class="w-full form-input" name="medicines[0][dosage]" placeholder="Dosage (e.g. 500mg)">
                        </div>
                        <div class="md:col-span-3">
                            <input type="text" class="w-full form-input" name="medicines[0][frequency]" placeholder="Frequency (e.g. 3x/day)">
                        </div>
                        <div class="md:col-span-1">
                            <button type="button" class="p-2 text-error-600 hover:bg-error-50 rounded-lg" onclick="removeMedicine(this)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" class="mt-3 px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-600" onclick="addMedicine()">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Medicine
                </button>
            </x-card>

            <!-- Action Buttons -->
            <div class="flex gap-3" id="action-buttons">
                <a href="{{ route('prescriptions.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" id="submit-btn" class="btn-primary">
                    <svg id="btn-icon" class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0V4a1 1 0 011-1h2a1 1 0 011 1v3m-4 0a1 1 0 001 1h2a1 1 0 001-1M4 7h16"/></svg>
                    <span id="btn-text">Generate Prescription</span>
                    <i class="fas fa-spinner fa-spin hidden ml-2" id="btn-spinner"></i>
                </button>
            </div>
        </form>

        <!-- Print/Download Options -->
        <div id="print-options" class="hidden mt-6">
            <x-card>
                <h5 class="text-lg font-semibold text-gray-900 mb-4">Prescription Created Successfully!</h5>
                <div class="flex gap-3">
                    <button onclick="window.print()" class="btn-primary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2-4h6a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4a2 2 0 012-2zm8 0V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v6"/></svg>
                        Print Prescription
                    </button>
                    <a href="#" id="download-pdf" class="btn-secondary">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download PDF
                    </a>
                    <button onclick="resetForm()" class="btn-secondary">
                        Create New Prescription
                    </button>
                </div>
            </x-card>
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
        dropdown.classList.add('hidden');
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch('{{ route("patients.autocomplete") }}?term=' + encodeURIComponent(searchTerm))
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    dropdown.innerHTML = data.data.map(p => {
                        const encoded = btoa(unescape(encodeURIComponent(JSON.stringify(p))));
                        return '<div class="px-4 py-2 hover:bg-gray-50 cursor-pointer" onclick="selectPatient(\'' + encoded + '\')">' +
                            '<span class="font-medium">' + p.unique_id + '</span> - ' + p.patient_name +
                            '<span class="text-sm text-gray-500 ml-2">Age: ' + p.age + ', ' + p.sex + '</span>' +
                            '</div>';
                    }).join('');
                    dropdown.classList.remove('hidden');
                } else {
                    dropdown.innerHTML = '<div class="px-4 py-2 text-gray-500">No patients found</div>';
                    dropdown.classList.remove('hidden');
                }
            });
    }, 300);
});

function selectPatient(encodedData) {
    const p = JSON.parse(decodeURIComponent(escape(atob(encodedData))));
    document.getElementById('patient-id').value = p.id;
    document.getElementById('patient-search').value = p.unique_id + ' - ' + p.patient_name;
    document.getElementById('patient-dropdown').classList.add('hidden');

    // Autofill patient info
    document.getElementById('info-unique-id').textContent = p.unique_id;
    document.getElementById('info-name').value = p.patient_name;
    document.getElementById('info-age').value = p.age;
    document.getElementById('info-sex').value = p.sex;
    document.getElementById('prescription-date').value = p.date || '{{ date("Y-m-d") }}';
    document.getElementById('existing-patient-info').classList.remove('hidden');

    // Hide new patient form
    document.getElementById('new-patient-toggle').checked = false;
    document.getElementById('new-patient-form').classList.add('hidden');
}

// New patient toggle
document.getElementById('new-patient-toggle').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('new-patient-form').classList.remove('hidden');
        document.getElementById('existing-patient-info').classList.add('hidden');
        document.getElementById('patient-id').value = '';
        document.getElementById('patient-search').value = '';
    } else {
        document.getElementById('new-patient-form').classList.add('hidden');
    }
});

// Close dropdown on click outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('#patient-search') && !e.target.closest('#patient-dropdown')) {
        document.getElementById('patient-dropdown').classList.add('hidden');
    }
});

// Medicine functions
function addMedicine() {
    const container = document.getElementById('medicines-container');
    const html = '<div class="grid grid-cols-1 md:grid-cols-12 gap-2 mb-2 medicine-row items-center">' +
        '<div class="md:col-span-5">' +
            '<input type="text" class="w-full form-input" name="medicines[' + medicineIndex + '][name]" placeholder="Medicine name">' +
        '</div>' +
        '<div class="md:col-span-3">' +
            '<input type="text" class="w-full form-input" name="medicines[' + medicineIndex + '][dosage]" placeholder="Dosage (e.g. 500mg)">' +
        '</div>' +
        '<div class="md:col-span-3">' +
            '<input type="text" class="w-full form-input" name="medicines[' + medicineIndex + '][frequency]" placeholder="Frequency (e.g. 3x/day)">' +
        '</div>' +
        '<div class="md:col-span-1">' +
            '<button type="button" class="p-2 text-error-600 hover:bg-error-50 rounded-lg" onclick="removeMedicine(this)">' +
                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' +
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
        alert('Please select a patient or create a new patient');
        return;
    }

    // Collect medicines
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

    // Show loading state
    const submitBtn = document.getElementById('submit-btn');
    const btnIcon = document.getElementById('btn-icon');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    submitBtn.disabled = true;
    btnIcon.classList.add('hidden');
    btnText.textContent = 'Generating...';
    btnSpinner.classList.remove('hidden');

    // Build form data
    const formData = new FormData(this);
    formData.set('medicines', JSON.stringify(medicines));

    // Submit via fetch
    fetch('{{ route("prescriptions.store") }}', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            createdPrescriptionId = data.prescription_id;
            document.getElementById('download-pdf').href = '{{ url("/prescriptions") }}/' + createdPrescriptionId;
            document.getElementById('action-buttons').classList.add('hidden');
            document.getElementById('print-options').classList.remove('hidden');
            window.scrollTo({ top: document.getElementById('print-options').offsetTop, behavior: 'smooth' });
        } else {
            alert('Error creating prescription: ' + (data.message || 'Unknown error'));
            submitBtn.disabled = false;
            btnIcon.classList.remove('hidden');
            btnText.textContent = 'Generate Prescription';
            btnSpinner.classList.add('hidden');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error creating prescription');
    });
});

function resetForm() {
    // Reset form
    document.getElementById('prescription-form').reset();
    document.getElementById('patient-id').value = '';
    document.getElementById('patient-search').value = '';
    document.getElementById('existing-patient-info').classList.add('hidden');
    document.getElementById('new-patient-form').classList.add('hidden');
    document.getElementById('new-patient-toggle').checked = false;
    document.getElementById('selected-problems').innerHTML = '';
    document.getElementById('selected-tests').innerHTML = '';
    document.getElementById('medicines-container').innerHTML = '<div class="grid grid-cols-12 gap-2 mb-2 medicine-row items-center">' +
        '<div class="col-span-5">' +
            '<input type="text" class="w-full form-input" name="medicines[0][name]" placeholder="Medicine name">' +
        '</div>' +
        '<div class="col-span-3">' +
            '<input type="text" class="w-full form-input" name="medicines[0][dosage]" placeholder="Dosage (e.g. 500mg)">' +
        '</div>' +
        '<div class="col-span-3">' +
            '<input type="text" class="w-full form-input" name="medicines[0][frequency]" placeholder="Frequency (e.g. 3x/day)">' +
        '</div>' +
        '<div class="col-span-1">' +
            '<button type="button" class="p-2 text-error-600 hover:bg-error-50 rounded-lg" onclick="removeMedicine(this)">' +
                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' +
            '</button>' +
        '</div>' +
    '</div>';
    medicineIndex = 1;

    // Show form, hide print options
    document.getElementById('action-buttons').classList.remove('hidden');
    document.getElementById('print-options').classList.add('hidden');

    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endpush
@endsection
