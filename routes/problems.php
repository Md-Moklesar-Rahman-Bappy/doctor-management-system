<?php

use App\Http\Controllers\ProblemController;
use Illuminate\Support\Facades\Route;

// Problem routes
Route::get('/problems', [ProblemController::class, 'index'])->name('problems.index');
Route::get('/problems/create', [ProblemController::class, 'create'])->name('problems.create');
Route::post('/problems', [ProblemController::class, 'store'])->name('problems.store');
Route::get('/problems/{id}', [ProblemController::class, 'show'])->name('problems.show');
Route::get('/problems/{id}/edit', [ProblemController::class, 'edit'])->name('problems.edit');
Route::put('/problems/{id}', [ProblemController::class, 'update'])->name('problems.update');
Route::delete('/problems/{id}', [ProblemController::class, 'destroy'])->name('problems.destroy');
Route::get('/problems/autocomplete', [ProblemController::class, 'autocomplete'])->name('problems.autocomplete');
