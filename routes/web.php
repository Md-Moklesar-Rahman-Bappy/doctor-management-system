<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\LabTestReportController;

// Medicine web routes (view-based)
Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
Route::post('/medicines/import', [MedicineController::class, 'import'])->name('medicines.import');
Route::get('/medicines/template', [MedicineController::class, 'template'])->name('medicines.template');
Route::get('/medicines/export-view', [MedicineController::class, 'export'])->name('medicines.export');
Route::get('/medicines/autocomplete', [MedicineController::class, 'autocomplete'])->name('medicines.autocomplete');
Route::get('/medicines/{id}', [MedicineController::class, 'show'])->name('medicines.show');
Route::get('/medicines/{id}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
Route::put('/medicines/{id}', [MedicineController::class, 'update'])->name('medicines.update');
Route::patch('/medicines/{id}', [MedicineController::class, 'update']);
Route::delete('/medicines/{id}', [MedicineController::class, 'destroy'])->name('medicines.destroy');

// Lab Test web routes
Route::get('/lab_tests', [LabTestController::class, 'index'])->name('lab_tests.index');
Route::get('/lab_tests/create', [LabTestController::class, 'create'])->name('lab_tests.create');
Route::post('/lab_tests', [LabTestController::class, 'store'])->name('lab_tests.store');
Route::post('/lab_tests/import', [LabTestController::class, 'import'])->name('lab_tests.import');
Route::get('/lab_tests/template', [LabTestController::class, 'template'])->name('lab_tests.template');
Route::get('/lab_tests/export', [LabTestController::class, 'export'])->name('lab_tests.export');
Route::get('/lab_tests/autocomplete', [LabTestController::class, 'autocomplete'])->name('lab_tests.autocomplete');
Route::get('/lab_tests/{id}', [LabTestController::class, 'show'])->name('lab_tests.show');
Route::get('/lab_tests/{id}/edit', [LabTestController::class, 'edit'])->name('lab_tests.edit');
Route::put('/lab_tests/{id}', [LabTestController::class, 'update'])->name('lab_tests.update');
Route::delete('/lab_tests/{id}', [LabTestController::class, 'destroy'])->name('lab_tests.destroy');

// Doctor routes
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
Route::get('/doctors/{id}', [DoctorController::class, 'show'])->name('doctors.show');
Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('doctors.update');
Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

// Patient routes
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
Route::get('/patients/autocomplete', [PatientController::class, 'autocomplete'])->name('patients.autocomplete');
Route::get('/patients/unique/{uniqueId}', [PatientController::class, 'getByUniqueId'])->name('patients.byUniqueId');

// Prescription routes
Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
Route::get('/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
Route::get('/prescriptions/{id}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
Route::get('/prescriptions/{id}/edit', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
Route::put('/prescriptions/{id}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
Route::delete('/prescriptions/{id}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
Route::get('/prescriptions/patient/{patientId}/history', [PrescriptionController::class, 'getPatientPrescriptions'])->name('prescriptions.patientHistory');

// Problem routes
Route::get('/problems', [ProblemController::class, 'index'])->name('problems.index');
Route::get('/problems/create', [ProblemController::class, 'create'])->name('problems.create');
Route::post('/problems', [ProblemController::class, 'store'])->name('problems.store');
Route::get('/problems/{id}', [ProblemController::class, 'show'])->name('problems.show');
Route::get('/problems/{id}/edit', [ProblemController::class, 'edit'])->name('problems.edit');
Route::put('/problems/{id}', [ProblemController::class, 'update'])->name('problems.update');
Route::delete('/problems/{id}', [ProblemController::class, 'destroy'])->name('problems.destroy');
Route::get('/problems/autocomplete', [ProblemController::class, 'autocomplete'])->name('problems.autocomplete');

// Lab Test Reports routes
Route::get('/lab-test-reports', [LabTestReportController::class, 'index'])->name('lab_test_reports.index');
Route::get('/lab-test-reports/create', [LabTestReportController::class, 'create'])->name('lab_test_reports.create');
Route::post('/lab-test-reports', [LabTestReportController::class, 'store'])->name('lab_test_reports.store');
Route::get('/lab-test-reports/{id}', [LabTestReportController::class, 'show'])->name('lab_test_reports.show');
Route::get('/lab-test-reports/{id}/edit', [LabTestReportController::class, 'edit'])->name('lab_test_reports.edit');
Route::put('/lab-test-reports/{id}', [LabTestReportController::class, 'update'])->name('lab_test_reports.update');
Route::delete('/lab-test-reports/{id}', [LabTestReportController::class, 'destroy'])->name('lab_test_reports.destroy');

// Dashboard
Route::get('/dashboard', function () {
    $stats = [
        'doctors' => \App\Models\Doctor::count(),
        'patients' => \App\Models\Patient::count(),
        'prescriptions' => \App\Models\Prescription::count(),
        'labReports' => \App\Models\LabTestReport::count(),
    ];
    return view('dashboard', compact('stats'));
})->middleware('auth');

// AJAX search routes
Route::get('/doctors/search', [DoctorController::class, 'search'])->name('doctors.search');
Route::get('/prescriptions/search', [PrescriptionController::class, 'search'])->name('prescriptions.search');

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';
