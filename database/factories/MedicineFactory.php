<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    protected $model = Medicine::class;

    public function definition()
    {
        return [
            'brand_name' => $this->faker->word . ' ' . $this->faker->randomNumber(3),
            'generic_name' => $this->faker->word,
            'dosage_type' => $this->faker->randomElement(['Tablet', 'Capsule', 'Syrup', 'Injection']),
            'strength' => $this->faker->randomElement(['100mg', '200mg', '500mg', '10mg']),
            'company_name' => $this->faker->company,
            'package_mark' => $this->faker->randomElement(['Strip', 'Bottle', 'Box']),
        ];
    }
}
