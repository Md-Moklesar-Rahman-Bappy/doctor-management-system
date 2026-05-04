<?php
$content = file_get_contents('resources/views/prescriptions/create.blade.php');

// Find the @push('scripts') section and replace everything until @endpush
$startMarker = "@push('scripts')\n<script>";
$endMarker = "</script>\n@endpush";

$startPos = strpos($content, $startMarker);
$endPos = strpos($content, $endMarker);

if ($startPos !== false && $endPos !== false) {
    $before = substr($content, 0, $startPos);
    $after = substr($content, $endPos + strlen($endMarker));
    
    $newScript = $startMarker . "
let medicineIndex = 0;
let searchTimeout;
let createdPrescriptionId = null;

// Patient search with live AJAX
document.addEventListener('DOMContentLoaded', function() {
    const patientSearch = document.getElementById('patient-search');
    const patientDropdown = document.getElementById('patient-dropdown');
    
    if (patientSearch && patientDropdown) {
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
                                html += '<div class=\"px-3 py-2 hover-bg-light cursor-pointer\" onclick=\"window.selectPatient(this)\"' +
                                    ' data-id=\"' + p.id + '\"' +
                                    ' data-unique-id=\"' + p.unique_id + '\"' +
                                    ' data-name=\"' + p.patient_name.replace(/\"/g, '&quot;') + '\"' +
                                    ' data-age=\"' + p.age + '\"' +
                                    ' data-sex=\"' + p.sex + '\">' +
                                    '<span class=\"fw-medium\">' + p.unique_id + '</span> - ' + p.patient_name +
                                    '<span class=\"text-muted small ms-2\">Age: ' + p.age + ', ' + p.sex + '</span>' +
                                    '</div>';
                            });
                            patientDropdown.innerHTML = html;
                            patientDropdown.classList.remove('d-none');
                        } else {
                            patientDropdown.innerHTML = '<div class=\"px-3 py-2 text-muted\">No patients found</div>';
                            patientDropdown.classList.remove('d-none');
                        }
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                        patientDropdown.innerHTML = '<div class=\"px-3 py-2 text-muted\">Error searching</div>';
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
    }
    
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
    document.getElementById('prescription-date').value = new Date().toISOString().split('T')[0];
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
        historyHtml += '<div class=\"mt-3\"><label class=\"small text-muted\">Prescription History (' + p.prescriptions.length + ')</label>' +
            '<div class=\"border rounded p-2 bg-white\" style=\"max-height: 150px; overflow-y: auto;\">';
        p.prescriptions.slice(0, 5).forEach(pr => {
            const problems = pr.problem ? (typeof pr.problem === 'string' ? JSON.parse(pr.problem) : pr.problem) : [];
            historyHtml += '<div class=\"small py-1 border-bottom\">' +
                '<i class=\"fas fa-prescription-bottle-alt text-primary me-1\"></i>' +
                (pr.prescription_date || 'N/A') + ' - ' + (problems.length > 0 ? problems.join(', ') : 'No problems') +
                '</div>';
        });
        if (p.prescriptions.length > 5) {
            historyHtml += '<div class=\"small text-muted py-1\">...and ' + (p.prescriptions.length - 5) + ' more</div>';
        }
        historyHtml += '</div></div>';
    }
    
    if (p.lab_test_reports && p.lab_test_reports.length > 0) {
        historyHtml += '<div class=\"mt-3\"><label class=\"small text-muted\">Lab Test Reports (' + p.lab_test_reports.length + ')</label>' +
            '<div class=\"border rounded p-2 bg-white\" style=\"max-height: 100px; overflow-y: auto;\">';
        p.lab_test_reports.slice(0, 3).forEach(lr => {
            historyHtml += '<div class=\"small py-1 border-bottom\">' +
                '<i class=\"fas fa-vial text-info me-1\"></i>' +
                (lr.test_name || 'Lab Test') + ' - ' + (lr.date || 'N/A') +
                '</div>';
        });
        if (p.lab_test_reports.length > 3) {
            historyHtml += '<div class=\"small text-muted py-1\">...and ' + (p.lab_test_reports.length - 3) + ' more</div>';
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

// Problem functions
function addProblem() {
    const container = document.getElementById('problems-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2 problem-row';
    div.innerHTML = '<div class=\"input-icon-wrapper flex-1\">' +
        '<input type=\"text\" name=\"problem[]\" class=\"form-control ps-4\" placeholder=\"e.g., Fever\">' +
        '<div class=\"icon\"><i class=\"fas fa-stethoscope\"></i></div>' +
        '</div>' +
        '<button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"removeProblem(this)\">' +
        '<i class=\"fas fa-times\"></i></button>';
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
    div.innerHTML = '<div class=\"input-icon-wrapper flex-1\">' +
        '<input type=\"text\" name=\"tests[]\" class=\"form-control ps-4\" placeholder=\"e.g., Blood Test\">' +
        '<div class=\"icon\"><i class=\"fas fa-vial\"></i></div>' +
        '</div>' +
        '<button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"removeTest(this)\">' +
        '<i class=\"fas fa-times\"></i></button>';
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
    div.innerHTML = '<div class=\"card-body p-3\">' +
        '<div class=\"row g-2 align-items-center\">' +
        '<div class=\"col-md-4\">' +
        '<div class=\"input-group\">' +
        '<span class=\"input-group-text bg-light border-end-0\"><i class=\"fas fa-pills text-muted\"></i></span>' +
        '<input type=\"text\" class=\"form-control border-start-0 medicine-search-input\" placeholder=\"Search brand or generic name...\" onkeyup=\"searchMedicine(this, event)\">' +
        '<div class=\"medicine-dropdown position-absolute start-0 top-100 mt-1 w-100 shadow-lg bg-white rounded-3 border d-none\" style=\"z-index: 1050; max-height: 200px; overflow-y: auto;\"></div>' +
        '</div>' +
        '</div>' +
        '<div class=\"col-md-3\"><input type=\"text\" class=\"form-control medicine-dosage\" placeholder=\"Dosage (e.g. 500mg)\"></div>' +
        '<div class=\"col-md-3\"><input type=\"text\" class=\"form-control medicine-frequency\" placeholder=\"When (e.g. 3x/day)\"></div>' +
        '<div class=\"col-md-2\"><input type=\"text\" class=\"form-control medicine-duration\" placeholder=\"Duration (e.g. 7 days)\"></div>' +
        '</div>' +
        '<div class=\"mt-2 d-flex gap-2 align-items-center\">' +
        '<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"addMedicine(this)\"><i class=\"fas fa-check me-1\"></i> Add</button>' +
        '<button type=\"button\" class=\"btn btn-sm btn-outline-danger\" onclick=\"removeMedicineSearch(this)\"><i class=\"fas fa-times\"></i></button>' +
        '</div>' +
        '<div class=\"selected-medicine mt-2 d-none\"><span class=\"badge bg-success\"></span></div>' +
        '<input type=\"hidden\" class=\"medicine-id\" name=\"medicines[' + medicineIndex + '][id]\" value=\"\">' +
        '<input type=\"hidden\" class=\"medicine-name\" name=\"medicines[' + medicineIndex + '][name]\" value=\"\">' +
        '<input type=\"hidden\" class=\"medicine-dosage-hidden\" name=\"medicines[' + medicineIndex + '][dosage]\" value=\"\">' +
        '<input type=\"hidden\" class=\"medicine-frequency-hidden\" name=\"medicines[' + medicineIndex + '][frequency]\" value=\"\">' +
        '<input type=\"hidden\" class=\"medicine-duration-hidden\" name=\"medicines[' + medicineIndex + '][duration]\" value=\"\">' +
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
                        const brand = m.brand_name.replace(/'/g, \"\\\\'\");
                        const generic = (m.generic_name || '').replace(/'/g, \"\\\\'\");
                        const strength = (m.strength || '').replace(/'/g, \"\\\\'\");
                        return '<div class=\"px-3 py-2 hover-bg-light cursor-pointer\" onclick=\"selectMedicine(this, \\'' + m.id + '\\', \\'' + brand + '\\', \\'' + generic + '\\', \\'' + strength + '\\')\">' +
                            '<div class=\"fw-medium\">' + m.brand_name + '</div>' +
                            (m.generic_name ? '<div class=\"small text-muted\">' + m.generic_name + '</div>' : '') +
                            (m.strength ? '<div class=\"small text-muted\">' + m.strength + '</div>' : '') +
                            '</div>';
                    }).join('');
                    dropdown.classList.remove('d-none');
                } else {
                    dropdown.innerHTML = '<div class=\"px-3 py-2 text-muted\">No medicines found</div>';
                    dropdown.classList.remove('d-none');
                }
            });
    }, 300);
}

function selectMedicine(el, id, brandName, genericName, strength) {
    const row = el.closest('.medicine-search-row');
    if (!row) return;
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
    document.querySelectorAll('.problem-row input[name=\"problem[]\"]').forEach(input => {
        if (input.value.trim()) problems.push(input.value.trim());
    });
    
    const tests = [];
    document.querySelectorAll('.test-row input[name=\"tests[]\"]').forEach(input => {
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
    
    fetch('" . route('prescriptions.store') . "', {
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
    document.getElementById('problems-container').innerHTML = '<div class=\"input-group mb-2 problem-row\">' +
        '<div class=\"input-icon-wrapper flex-1\">' +
        '<input type=\"text\" name=\"problem[]\" class=\"form-control ps-4\" placeholder=\"e.g., Fever\">' +
        '<div class=\"icon\"><i class=\"fas fa-stethoscope\"></i></div>' +
        '</div>' +
        '<button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"removeProblem(this)\" disabled>' +
        '<i class=\"fas fa-times\"></i></button>' +
        '</div>';
    document.getElementById('tests-container').innerHTML = '<div class=\"input-group mb-2 test-row\">' +
        '<div class=\"input-icon-wrapper flex-1\">' +
        '<input type=\"text\" name=\"tests[]\" class=\"form-control ps-4\" placeholder=\"e.g., Blood Test\">' +
        '<div class=\"icon\"><i class=\"fas fa-vial\"></i></div>' +
        '</div>' +
        '<button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"removeTest(this)\" disabled>' +
        '<i class=\"fas fa-times\"></i></button>' +
        '</div>';
    document.getElementById('medicines-container').innerHTML = '';
    medicineIndex = 0;
    
    document.getElementById('action-buttons').classList.remove('d-none');
    document.getElementById('print-options').classList.add('d-none');
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
" . $endMarker;
    
    $content = $before . $newScript . $after;
    file_put_contents('resources/views/prescriptions/create.blade.php', $content);
    echo "Script section replaced with clean version\n";
} else {
    echo "Could not find script section\n";
}
