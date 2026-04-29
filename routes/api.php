<?php

use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Support\Facades\Route;

// Dashboard chart data
Route::get('/dashboard-chart-data', function () {
    // Prescriptions trend (last 7 days)
    $prescriptions = [];
    $labels = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i)->format('Y-m-d');
        $labels[] = now()->subDays($i)->format('M d');
        $prescriptions[] = Prescription::whereDate('created_at', $date)->count();
    }

    // Gender distribution
    $male = Patient::where('sex', 'male')->count();
    $female = Patient::where('sex', 'female')->count();
    $other = Patient::whereNotIn('sex', ['male', 'female'])->count();

    return response()->json([
        'prescriptions' => [
            'labels' => $labels,
            'data' => $prescriptions,
        ],
        'gender' => [
            'male' => $male,
            'female' => $female,
            'other' => $other,
        ],
    ]);
});
