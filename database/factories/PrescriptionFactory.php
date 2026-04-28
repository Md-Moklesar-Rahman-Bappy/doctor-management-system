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
            'patient_id' => $this->faker->numberBetween(1, 10),
            'doctor_id' => $this->faker->numberBetween(1, 5),
            'prescription_date' => $this->faker->date,
            'valid_until' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            'notes' => $this->faker->paragraph,
        ];
    }
}

class PrescriptionSeeder
{
    public static function run()
    {
        $prescriptions = [
            ['patient_id' => 1, 'doctor_id' => 1, 'prescription_date' => '2024-01-01', 'valid_until' => '2024-02-01', 'notes' => 'Take as directed'],
        ];

        foreach ($prescriptions as $prescriptionData) {
            Prescription::firstOrCreate($prescriptionData);
        }
    }
}