<?php

namespace Database\Factories;

use App\Models\TestResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestResultFactory extends Factory
{
    protected $model = TestResult::class;

    public function definition()
    {
        return [
            'patient_id' => $this->faker->numberBetween(1, 10),
            'test_id' => $this->faker->numberBetween(1, 10),
            'prescription_id' => $this->faker->optional()->numberBetween(1, 5),
            'result_value' => $this->faker->word,
            'observations' => $this->faker->sentence,
            'test_date' => $this->faker->date,
        ];
    }
}

class TestResultSeeder
{
    public static function run()
    {
        $results = [
            ['patient_id' => 1, 'test_id' => 1, 'prescription_id' => 1, 'result_value' => 'Normal', 'observations' => 'All values within normal range', 'test_date' => '2024-01-15'],
        ];

        foreach ($results as $resultData) {
            TestResult::firstOrCreate($resultData);
        }
    }
}