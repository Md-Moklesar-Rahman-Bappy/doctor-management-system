<?php

use App\Http\Controllers\PrescriptionController;
use Illuminate\Support\Facades\Route;

// Prescription routes
Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
Route::get('/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
Route::get('/prescriptions/{id}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
Route::get('/prescriptions/{id}/download', [PrescriptionController::class, 'downloadPdf'])->name('prescriptions.download');
Route::get('/prescriptions/{id}/edit', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
Route::put('/prescriptions/{id}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
Route::delete('/prescriptions/{id}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
Route::get('/prescriptions/patient/{patientId}/history', [PrescriptionController::class, 'getPatientPrescriptions'])->name('prescriptions.patientHistory');
Route::get('/prescriptions/search', [PrescriptionController::class, 'search'])->name('prescriptions.search');
