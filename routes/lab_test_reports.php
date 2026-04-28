<?php

use App\Http\Controllers\LabTestReportController;
use Illuminate\Support\Facades\Route;

// Lab Test Reports routes
Route::get('/lab-test-reports', [LabTestReportController::class, 'index'])->name('lab_test_reports.index');
Route::get('/lab-test-reports/create', [LabTestReportController::class, 'create'])->name('lab_test_reports.create');
Route::post('/lab-test-reports', [LabTestReportController::class, 'store'])->name('lab_test_reports.store');
Route::get('/lab-test-reports/{id}', [LabTestReportController::class, 'show'])->name('lab_test_reports.show');
Route::get('/lab-test-reports/{id}/edit', [LabTestReportController::class, 'edit'])->name('lab_test_reports.edit');
Route::put('/lab-test-reports/{id}', [LabTestReportController::class, 'update'])->name('lab_test_reports.update');
Route::delete('/lab-test-reports/{id}', [LabTestReportController::class, 'destroy'])->name('lab_test_reports.destroy');
