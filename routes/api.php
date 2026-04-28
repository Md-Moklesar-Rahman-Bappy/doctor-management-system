<?php

use App\Http\Controllers\MedicineController;
use Illuminate\Support\Facades\Route;

// API routes for medicines - return JSON (protected by auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/medicines', [MedicineController::class, 'apiIndex']);
    Route::post('/medicines', [MedicineController::class, 'apiStore']);
    Route::get('/medicines/{id}', [MedicineController::class, 'apiShow']);
    Route::put('/medicines/{id}', [MedicineController::class, 'apiUpdate']);
    Route::delete('/medicines/{id}', [MedicineController::class, 'apiDestroy']);
    Route::get('/medicines/search', [MedicineController::class, 'search']);
    Route::get('/medicines/autocomplete', [MedicineController::class, 'autocomplete']);
});
