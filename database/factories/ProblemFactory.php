<?php

namespace Database\Factories;

use App\Models\Problem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProblemFactory extends Factory
{
    protected $model = Problem::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }
}

// Pre-added problems
class ProblemSeeder
{
    public static function run()
    {
        $problems = [
            'Fever',
            'Cough',
            'Headache',
            'Stomach Pain',
            'Back Pain',
            'Fatigue',
            'Dizziness',
            'Nausea',
            'Sore Throat',
            'Runny Nose',
        ];

        foreach ($problems as $problem) {
            Problem::firstOrCreate(['name' => $problem]);
        }
    }
}