<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestFactory extends Factory
{
    protected $model = Test::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'category' => $this->faker->randomElement(['Blood Test', 'Imaging', 'Cardiology', 'Urine Test']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}

// Pre-added tests
class TestSeeder
{
    public static function run()
    {
        $preAdded = Test::getPreAddedTests();
        foreach ($preAdded as $testData) {
            Test::firstOrCreate($testData);
        }
    }
}