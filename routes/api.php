<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;

// API routes for medicines - return JSON
Route::get('/medicines', [MedicineController::class, 'apiIndex']);
Route::post('/medicines', [MedicineController::class, 'apiStore']);
Route::get('/medicines/{id}', [MedicineController::class, 'apiShow']);
Route::put('/medicines/{id}', [MedicineController::class, 'apiUpdate']);
Route::delete('/medicines/{id}', [MedicineController::class, 'apiDestroy']);
Route::get('/medicines/search', [MedicineController::class, 'search']);
Route::get('/medicines/autocomplete', [MedicineController::class, 'autocomplete']);