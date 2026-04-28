<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition()
    {
        return [
            'user_id' => 1, // Will be set in actual usage
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'date_of_birth' => $this->faker->date,
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'medical_history' => $this->faker->sentence,
        ];
    }
}

class PatientSeeder
{
    public static function run()
    {
        $patients = [
            ['user_id' => 1, 'gender' => 'Male', 'date_of_birth' => '1980-01-01', 'blood_group' => 'A+', 'medical_history' => 'None'],
            ['user_id' => 2, 'gender' => 'Female', 'date_of_birth' => '1990-05-15', 'blood_group' => 'B-', 'medical_history' => 'Hypertension'],
        ];

        foreach ($patients as $patientData) {
            Patient::firstOrCreate($patientData);
        }
    }
}