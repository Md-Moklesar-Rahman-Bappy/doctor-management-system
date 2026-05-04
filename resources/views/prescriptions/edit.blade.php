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
                        <h5 class="card-title fw-semibold mb-0">Problems</h5>
                    </div>
                    <div class="card-body">
                        <div id="problems-container">
                            @if($prescription->problem && count(json_decode($prescription->problem, true)) > 0)
                                @foreach(json_decode($prescription->problem, true) as $problem)
                                    <div class="input-group mb-2 problem-row">
                                        <div class="input-icon-wrapper flex-1">
                                            <input type="text" name="problem[]" class="form-control ps-4"
                                                   value="{{ $problem }}" placeholder="e.g., Fever">
                                            <div class="icon"><i class="fas fa-stethoscope"></i></div>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeProblem(this)" {{ $loop->first && $loop->count == 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 problem-row">
                                    <div class="input-icon-wrapper flex-1">
                                        <input type="text" name="problem[]" class="form-control ps-4"
                                               placeholder="e.g., Fever">
                                        <div class="icon"><i class="fas fa-stethoscope"></i></div>
                                    </div>
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
                        <h5 class="card-title fw-semibold mb-0">Tests</h5>
                    </div>
                    <div class="card-body">
                        <div id="tests-container">
                            @if($prescription->tests && count(json_decode($prescription->tests, true)) > 0)
                                @foreach(json_decode($prescription->tests, true) as $test)
                                    <div class="input-group mb-2 test-row">
                                        <div class="input-icon-wrapper flex-1">
                                            <input type="text" name="tests[]" class="form-control ps-4"
                                                   value="{{ $test }}" placeholder="e.g., Blood Test">
                                            <div class="icon"><i class="fas fa-vial"></i></div>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeTest(this)" {{ $loop->first && $loop->count == 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 test-row">
                                    <div class="input-icon-wrapper flex-1">
                                        <input type="text" name="tests[]" class="form-control ps-4"
                                               placeholder="e.g., Blood Test">
                                        <div class="icon"><i class="fas fa-vial"></i></div>
                                    </div>
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
                        <h5 class="card-title fw-semibold mb-0">Medicines</h5>
                    </div>
                    <div class="card-body">
                        <div id="medicines-container">
                            @if($prescription->medicines)
                                @php
                                    $meds = json_decode($prescription->medicines, true) ?? [];
                                @endphp
                                @foreach($meds as $index => $med)
                                    <div class="card mb-2 medicine-search-row">
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
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control medicine-dosage" value="{{ $med['dosage'] ?? '' }}" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control medicine-frequency" value="{{ $med['frequency'] ?? '' }}" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control medicine-duration" value="{{ $med['duration'] ?? '' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="medicine-id" name="medicines[{{ $index }}][id]" value="{{ $med['id'] ?? '' }}">
                                        <input type="hidden" class="medicine-name" name="medicines[{{ $index }}][name]" value="{{ $med['name'] ?? '' }}">
                                        <input type="hidden" class="medicine-dosage-hidden" name="medicines[{{ $index }}][dosage]" value="{{ $med['dosage'] ?? '' }}">
                                        <input type="hidden" class="medicine-frequency-hidden" name="medicines[{{ $index }}][frequency]" value="{{ $med['frequency'] ?? '' }}">
                                        <input type="hidden" class="medicine-duration-hidden" name="medicines[{{ $index }}][duration]" value="{{ $med['duration'] ?? '' }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addMedicineSearch()">
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
<script>
let medicineIndex = {{ $prescription->medicines ? count(json_decode($prescription->medicines, true)) : 0 }};

// Medicine search functions
function addMedicineSearch() {
    const container = document.getElementById('medicines-container');

    const div = document.createElement('div');
    div.className = 'card mb-2 medicine-search-row';
    div.innerHTML = `
        <div class="card-body p-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-pills text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 medicine-search-input"
                               placeholder="Search brand or generic name..."
                               onkeyup="searchMedicine(this, event)">
                        <div class="medicine-dropdown position-absolute start-0 top-100 mt-1 w-100 shadow-lg bg-white rounded-3 border d-none" style="z-index: 1050; max-height: 200px; overflow-y: auto;"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control medicine-dosage" placeholder="Dosage (e.g. 500mg)">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control medicine-frequency" placeholder="When (e.g. 3x/day)">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control medicine-duration" placeholder="Duration (e.g. 7 days)">
                </div>
            </div>
            <div class="mt-2 d-flex gap-2 align-items-center">
                <button type="button" class="btn btn-sm btn-primary" onclick="addMedicine(this)">
                    <i class="fas fa-check me-1"></i> Add
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeMedicineSearch(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="selected-medicine mt-2 d-none">
                <span class="badge bg-success"></span>
            </div>
            <input type="hidden" class="medicine-id" name="medicines[${medicineIndex}][id]" value="">
            <input type="hidden" class="medicine-name" name="medicines[${medicineIndex}][name]" value="">
            <input type="hidden" class="medicine-dosage-hidden" name="medicines[${medicineIndex}][dosage]" value="">
            <input type="hidden" class="medicine-frequency-hidden" name="medicines[${medicineIndex}][frequency]" value="">
            <input type="hidden" class="medicine-duration-hidden" name="medicines[${medicineIndex}][duration]" value="">
        </div>
    `;

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
        fetch('{{ route("medicines.autocomplete") }}?term=' + encodeURIComponent(term))
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

function selectMedicine(element, id, brandName, genericName, strength) {
    const row = element.closest('.medicine-search-row');
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

    // Disable inputs after adding
    row.querySelector('.medicine-dosage').disabled = true;
    row.querySelector('.medicine-frequency').disabled = true;
    row.querySelector('.medicine-duration').disabled = true;
    button.disabled = true;

    // Change button to remove
    const removeBtn = row.querySelector('.btn-outline-danger');
    removeBtn.onclick = function() { row.remove(); };
}

function removeMedicineSearch(button) {
    button.closest('.medicine-search-row').remove();
}

// Problem functions
function addProblem() {
    const container = document.getElementById('problems-container');

    const div = document.createElement('div');
    div.className = 'input-group mb-2 problem-row';
    div.innerHTML = `
        <div class="input-icon-wrapper flex-1">
            <input type="text" name="problem[]" class="form-control ps-4"
                   placeholder="e.g., Fever">
            <div class="icon"><i class="fas fa-stethoscope"></i></div>
        </div>
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
        <div class="input-icon-wrapper flex-1">
            <input type="text" name="tests[]" class="form-control ps-4"
                   placeholder="e.g., Blood Test">
            <div class="icon"><i class="fas fa-vial"></i></div>
        </div>
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
    document.querySelectorAll('.test-row input[name="tests[]"]').forEach(input => {
        if (input.value.trim()) {
            tests.push(input.value.trim());
        }
    });

    // Collect medicines
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
