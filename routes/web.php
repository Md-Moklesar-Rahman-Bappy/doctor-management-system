<?php

use App\Models\Doctor;
use App\Models\LabTestReport;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Support\Facades\Route;

// Include modular route files
require __DIR__.'/medicines.php';
require __DIR__.'/lab-tests.php';
require __DIR__.'/doctors.php';
require __DIR__.'/patients.php';
require __DIR__.'/prescriptions.php';
require __DIR__.'/problems.php';
require __DIR__.'/lab_test_reports.php';

// Dashboard
Route::get('/dashboard', function () {
    $stats = [
        'doctors' => Doctor::count(),
        'patients' => Patient::count(),
        'prescriptions' => Prescription::count(),
        'labReports' => LabTestReport::count(),
    ];

    return view('dashboard', compact('stats'));
})->middleware('auth')->name('dashboard');

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
require __DIR__.'/auth.php';
