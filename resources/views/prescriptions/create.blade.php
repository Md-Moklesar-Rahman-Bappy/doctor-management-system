@extends('layouts.dashboard')

@section('content')
<div>
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="/prescriptions" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h3 class="text-2xl font-bold text-slate-900">Create Prescription</h3>
        </div>
        <p class="text-slate-500">Search or create patient, then add problems, tests, and medicines</p>
    </div>

    <div class="max-w-5xl">
        <!-- Doctor Info (Auto-selected) -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-slate-900">{{ $doctor->name ?? 'No doctor profile' }}</div>
                    <div class="text-sm text-slate-500">{{ auth()->user()->email }}</div>
                </div>
            </div>
        </div>

        <!-- Patient Search & Info -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
            <h5 class="text-lg font-semibold text-slate-900 mb-4">Patient Information</h5>

            <!-- Search Existing Patient -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Search Patient by ID *</label>
                <div class="relative">
                    <input type="text" id="patient-search" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Type patient unique ID (e.g. PAT-12345678)..." autocomplete="off">
                    <div id="patient-dropdown" class="absolute z-10 w-full bg-white border border-slate-200 rounded-lg shadow-lg mt-1 hidden max-h-48 overflow-y-auto"></div>
                </div>
                <input type="hidden" name="patient_id" id="patient-id" value="{{ $selectedPatientId ?? '' }}">
            </div>

            <!-- Toggle New Patient -->
            <div class="mb-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="new-patient-toggle" class="rounded border-slate-300 text-emerald-500 focus:ring-emerald-500">
                    <span class="ml-2 text-sm text-slate-600">Create new patient</span>
                </label>
            </div>

            <!-- Existing Patient Info (Autofill) -->
            <div id="existing-patient-info" class="{{ $selectedPatientId ? '' : 'hidden' }}">
                <div class="p-4 bg-slate-50 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Unique ID</label>
                            <p class="font-medium text-slate-900" id="info-unique-id">-</p>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Patient Name</label>
                            <input type="text" id="info-name" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-100" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Age</label>
                            <input type="text" id="info-age" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-100" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 mb-1">Sex</label>
                            <input type="text" id="info-sex" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-100" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Prescription Date *</label>
                        <input type="date" name="prescription_date" id="prescription-date" class="px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <!-- New Patient Form -->
            <div id="new-patient-form" class="hidden">
                <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                    <h6 class="font-semibold text-slate-700 mb-3">New Patient Details</h6>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Patient Name *</label>
                            <input type="text" name="new_patient_name" id="new-patient-name" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                   placeholder="Enter patient name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Age *</label>
                            <input type="number" name="new_patient_age" id="new-patient-age" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                   placeholder="Age" min="0" max="150">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Sex *</label>
                            <select name="new_patient_sex" id="new-patient-sex" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="">Select Sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Date *</label>
                            <input type="date" name="new_patient_date" id="new-patient-date" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                   value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Problems -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
            <h5 class="text-lg font-semibold text-slate-900 mb-4">Problems</h5>
            <div id="problems-container">
                <div class="flex items-center gap-2 mb-2">
                    <input type="text" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg problem-search" placeholder="Type to search problems...">
                    <button type="button" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 text-sm font-medium" onclick="addProblem(this)">Add</button>
                </div>
                <div id="selected-problems"></div>
            </div>
            <input type="hidden" name="problem[]" id="problems-json">
        </div>

        <!-- Tests -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
            <h5 class="text-lg font-semibold text-slate-900 mb-4">Tests</h5>
            <div id="tests-container">
                <div class="flex items-center gap-2 mb-2">
                    <input type="text" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg test-search" placeholder="Type to search lab tests...">
                    <button type="button" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 text-sm font-medium" onclick="addTest(this)">Add</button>
                </div>
                <div id="selected-tests"></div>
            </div>
            <input type="hidden" name="tests[]" id="tests-json">
        </div>

        <!-- Medicines -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
            <h5 class="text-lg font-semibold text-slate-900 mb-4">Medicines</h5>
            <div id="medicines-container">
                <div class="grid grid-cols-12 gap-2 mb-2 medicine-row items-center">
                    <div class="col-span-5">
                        <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[0][name]" placeholder="Medicine name">
                    </div>
                    <div class="col-span-3">
                        <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[0][dosage]" placeholder="Dosage (e.g. 500mg)">
                    </div>
                    <div class="col-span-3">
                        <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[0][frequency]" placeholder="Frequency (e.g. 3x/day)">
                    </div>
                    <div class="col-span-1">
                        <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeMedicine(this)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" class="mt-3 px-4 py-2 text-sm border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-600" onclick="addMedicine()">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Medicine
            </button>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3" id="action-buttons">
            <a href="/prescriptions" class="px-6 py-2.5 border border-slate-200 rounded-lg hover:bg-slate-50 font-medium">Cancel</a>
            <button type="button" onclick="submitPrescription()" class="px-6 py-2.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-4 0a1 1 0 011-1h2a1 1 0 011 1v3M4 7h16"/></svg>
                Generate Prescription
            </button>
        </div>

        <!-- Print/Download Options (shown after save) -->
        <div id="print-options" class="hidden mt-6 p-6 bg-emerald-50 rounded-xl border border-emerald-200">
            <h5 class="text-lg font-semibold text-slate-900 mb-4">Prescription Created Successfully!</h5>
            <div class="flex gap-3">
                <button onclick="window.print()" class="px-6 py-2.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2-4h6a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4a2 2 0 012-2zm8 0V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v6"/></svg>
                    Print Prescription
                </button>
                <a href="#" id="download-pdf" class="px-6 py-2.5 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download PDF
                </a>
                <button onclick="resetForm()" class="px-6 py-2.5 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 font-medium">
                    Create New Prescription
                </button>
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

    if (searchTerm.length < 3) {
        dropdown.classList.add('hidden');
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch(`/patients/autocomplete?term=${encodeURIComponent(searchTerm)}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    dropdown.innerHTML = data.data.map(p => {
                        const patientData = JSON.stringify({id: p.id, unique_id: p.unique_id, name: p.patient_name, age: p.age, sex: p.sex, date: p.date}).replace(/"/g, '&quot;');
                        return `<div class="px-4 py-2 hover:bg-slate-100 cursor-pointer" onclick='selectPatient(${patientData})'>
                            <span class="font-medium">${p.unique_id}</span> - ${p.patient_name}
                            <span class="text-sm text-slate-500 ml-2">Age: ${p.age}, ${p.sex}</span>
                        </div>`;
                    }).join('');
                    dropdown.classList.remove('hidden');
                } else {
                    dropdown.innerHTML = '<div class="px-4 py-2 text-slate-500">No patients found</div>';
                    dropdown.classList.remove('hidden');
                }
            });
    }, 300);
});

function selectPatient(patient) {
    document.getElementById('patient-id').value = patient.id;
    document.getElementById('patient-search').value = patient.unique_id + ' - ' + patient.name;
    document.getElementById('patient-dropdown').classList.add('hidden');

    // Autofill patient info
    document.getElementById('info-unique-id').textContent = patient.unique_id;
    document.getElementById('info-name').value = patient.name;
    document.getElementById('info-age').value = patient.age;
    document.getElementById('info-sex').value = patient.sex;
    document.getElementById('prescription-date').value = patient.date || '{{ date("Y-m-d") }}';
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
    const html = `
        <div class="grid grid-cols-12 gap-2 mb-2 medicine-row items-center">
            <div class="col-span-5">
                <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[${medicineIndex}][name]" placeholder="Medicine name">
            </div>
            <div class="col-span-3">
                <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[${medicineIndex}][dosage]" placeholder="Dosage (e.g. 500mg)">
            </div>
            <div class="col-span-3">
                <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg" name="medicines[${medicineIndex}][frequency]" placeholder="Frequency (e.g. 3x/day)">
            </div>
            <div class="col-span-1">
                <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="removeMedicine(this)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    medicineIndex++;
}

function removeMedicine(btn) {
    btn.closest('.medicine-row').remove();
}

// Submit prescription via AJAX
function submitPrescription() {
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

    // Build form data
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('doctor_id', '{{ $doctor->id ?? '' }}');
    formData.append('problem[]', document.getElementById('problems-json').value || '[]');
    formData.append('tests[]', document.getElementById('tests-json').value || '[]');
    formData.append('medicines', JSON.stringify(medicines));

    if (patientId) {
        formData.append('patient_id', patientId);
    } else {
        formData.append('new_patient_name', newPatientName);
        formData.append('new_patient_age', document.getElementById('new-patient-age').value);
        formData.append('new_patient_sex', document.getElementById('new-patient-sex').value);
        formData.append('new_patient_date', document.getElementById('new-patient-date').value);
    }

    // Submit via fetch
    fetch('/prescriptions', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            createdPrescriptionId = data.prescription_id;
            document.getElementById('download-pdf').href = `/prescriptions/${createdPrescriptionId}`;
            document.getElementById('action-buttons').classList.add('hidden');
            document.getElementById('print-options').classList.remove('hidden');
        } else {
            alert('Error creating prescription: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        alert('Error creating prescription');
    });
}

function resetForm() {
    // Reset form
    document.getElementById('patient-id').value = '';
    document.getElementById('patient-search').value = '';
    document.getElementById('existing-patient-info').classList.add('hidden');
    document.getElementById('new-patient-form').classList.add('hidden');
    document.getElementById('new-patient-toggle').checked = false;
    document.getElementById('selected-problems').innerHTML = '';
    document.getElementById('selected-tests').innerHTML = '';
    document.getElementById('medicines-container').innerHTML = '';
    document.getElementById('problems-json').value = '';
    document.getElementById('tests-json').value = '';
    medicineIndex = 1;

    // Show form, hide print options
    document.getElementById('action-buttons').classList.remove('hidden');
    document.getElementById('print-options').classList.add('hidden');
}
</script>
@endpush
@endsection
