<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['Male', 'Female', 'Other']);
        return [
            'patient_name' => fake()->name(),
            'age' => fake()->numberBetween(1, 100),
            'sex' => strtolower($gender),
            'date' => fake()->date(),
            'unique_id' => 'P' . fake()->unique()->numberBetween(1000, 9999),
            'user_id' => 1, // Will be overridden in tests
        ];
    }
}
