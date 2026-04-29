<?php

namespace Database\Factories;

use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionFactory extends Factory
{
    protected $model = Prescription::class;

    public function definition()
    {
        return [
            'patient_id' => 1, // Will be overridden in tests
            'doctor_id' => 1, // Will be overridden in tests
            'problem' => json_encode(['Fever', 'Cough']),
            'tests' => json_encode(['Blood Test']),
            'medicines' => json_encode([['name' => 'Paracetamol', 'dosage' => '500mg']]),
        ];
    }
}