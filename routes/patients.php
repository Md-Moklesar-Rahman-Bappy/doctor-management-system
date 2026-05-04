<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

// Patient routes (specific routes BEFORE generic {id} route)
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/autocomplete', [PatientController::class, 'autocomplete'])->name('patients.autocomplete');
Route::get('/patients/unique/{uniqueId}', [PatientController::class, 'getByUniqueId'])->name('patients.byUniqueId');
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
