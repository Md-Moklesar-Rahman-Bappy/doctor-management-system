<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;

// Medicine CRUD routes
Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
Route::get('/medicines/search', [MedicineController::class, 'search'])->name('medicines.search');
Route::post('/medicines/search', [MedicineController::class, 'search']);
Route::get('/medicines/autocomplete', [MedicineController::class, 'autocomplete'])->name('medicines.autocomplete');
Route::get('/medicines/{id}', [MedicineController::class, 'show'])->name('medicines.show');
Route::put('/medicines/{id}', [MedicineController::class, 'update'])->name('medicines.update');
Route::patch('/medicines/{id}', [MedicineController::class, 'update']);
Route::delete('/medicines/{id}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
Route::get('/medicines/{id}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');

// Import/Export routes
Route::post('/medicines/import', [MedicineController::class, 'import'])->name('medicines.import');
Route::get('/medicines/export', [MedicineController::class, 'export'])->name('medicines.export');
Route::get('/medicines/export-failed', [MedicineController::class, 'exportFailed'])->name('medicines.export-failed');
Route::get('/medicines/template', [MedicineController::class, 'template'])->name('medicines.template');