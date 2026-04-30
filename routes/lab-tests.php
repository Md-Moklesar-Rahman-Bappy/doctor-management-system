<?php

use App\Http\Controllers\LabTestController;
use Illuminate\Support\Facades\Route;

// Lab Test web routes
Route::get('/lab-tests', [LabTestController::class, 'index'])->name('lab-tests.index');
Route::get('/lab-tests/create', [LabTestController::class, 'create'])->name('lab-tests.create');
Route::post('/lab-tests', [LabTestController::class, 'store'])->name('lab-tests.store');
Route::post('/lab-tests/import', [LabTestController::class, 'import'])->name('lab-tests.import');
Route::get('/lab-tests/template', [LabTestController::class, 'template'])->name('lab-tests.template');
Route::get('/lab-tests/export', [LabTestController::class, 'export'])->name('lab-tests.export');
Route::get('/lab-tests/autocomplete', [LabTestController::class, 'autocomplete'])->name('lab-tests.autocomplete');
Route::get('/lab-tests/download-duplicates', [LabTestController::class, 'downloadDuplicates'])->name('lab-tests.download-duplicates');
Route::get('/lab-tests/download-failed', [LabTestController::class, 'downloadFailed'])->name('lab-tests.download-failed');
Route::get('/lab-tests/{id}', [LabTestController::class, 'show'])->name('lab-tests.show');
Route::get('/lab-tests/{id}/edit', [LabTestController::class, 'edit'])->name('lab-tests.edit');
Route::put('/lab-tests/{id}', [LabTestController::class, 'update'])->name('lab-tests.update');
Route::delete('/lab-tests/{id}', [LabTestController::class, 'destroy'])->name('lab-tests.destroy');
