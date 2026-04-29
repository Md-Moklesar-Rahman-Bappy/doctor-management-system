<?php

namespace Database\Factories;

use App\Models\LabTest;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabTestFactory extends Factory
{
    protected $model = LabTest::class;

    public function definition()
    {
        return [
            'department' => $this->faker->randomElement(['Biochemistry', 'Hematology', 'Microbiology']),
            'sample_type' => $this->faker->randomElement(['Blood', 'Urine', 'Sputum']),
            'panel' => $this->faker->word,
            'test' => $this->faker->word,
            'code' => strtoupper($this->faker->lexify('????')),
            'unit' => $this->faker->randomElement(['U/L', 'mg/dL', 'g/dL']),
            'result_type' => $this->faker->randomElement(['Numeric', 'Text', 'Qualitative']),
            'normal_range' => $this->faker->randomElement(['0-100', 'Normal', 'Negative']),
        ];
    }
}
