<?php

use App\Http\Controllers\LabTestController;
use Illuminate\Support\Facades\Route;

// Lab Test web routes
Route::get('/lab_tests', [LabTestController::class, 'index'])->name('lab_tests.index');
Route::get('/lab_tests/create', [LabTestController::class, 'create'])->name('lab_tests.create');
Route::post('/lab_tests', [LabTestController::class, 'store'])->name('lab_tests.store');
Route::post('/lab_tests/import', [LabTestController::class, 'import'])->name('lab_tests.import');
Route::get('/lab_tests/template', [LabTestController::class, 'template'])->name('lab_tests.template');
Route::get('/lab_tests/export', [LabTestController::class, 'export'])->name('lab_tests.export');
Route::get('/lab_tests/autocomplete', [LabTestController::class, 'autocomplete'])->name('lab_tests.autocomplete');
Route::get('/lab_tests/download-duplicates', [LabTestController::class, 'downloadDuplicates'])->name('lab_tests.download-duplicates');
Route::get('/lab_tests/download-failed', [LabTestController::class, 'downloadFailed'])->name('lab_tests.download-failed');
Route::get('/lab_tests/{id}', [LabTestController::class, 'show'])->name('lab_tests.show');
Route::get('/lab_tests/{id}/edit', [LabTestController::class, 'edit'])->name('lab_tests.edit');
Route::put('/lab_tests/{id}', [LabTestController::class, 'update'])->name('lab_tests.update');
Route::delete('/lab_tests/{id}', [LabTestController::class, 'destroy'])->name('lab_tests.destroy');
