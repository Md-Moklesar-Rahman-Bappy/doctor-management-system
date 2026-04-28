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
            'name' => $this->faker->word,
            'generic_name' => $this->faker->word,
            'dosage' => $this->faker->randomElement(['100mg', '200mg', '500mg', '10mg']),
            'form' => $this->faker->randomElement(['Tablet', 'Capsule', 'Syrup', 'Injection']),
            'strength' => $this->faker->randomElement(['100', '200', '500', '10']),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'stock_quantity' => $this->faker->numberBetween(0, 200),
            'description' => $this->faker->sentence,
        ];
    }
}

// Pre-populate medicines
class MedicineSeeder
{
    public static function run()
    {
        $medicines = [
            ['name' => 'Paracetamol', 'generic_name' => 'Acetaminophen', 'dosage' => '500mg', 'form' => 'Tablet', 'strength' => '500', 'price' => 50.00, 'stock_quantity' => 100],
            ['name' => 'Ibuprofen', 'generic_name' => 'Ibuprofen', 'dosage' => '200mg', 'form' => 'Tablet', 'strength' => '200', 'price' => 80.00, 'stock_quantity' => 150],
            ['name' => 'Amoxicillin', 'generic_name' => 'Amoxicillin', 'dosage' => '500mg', 'form' => 'Capsule', 'strength' => '500', 'price' => 120.00, 'stock_quantity' => 80],
            ['name' => 'Omeprazole', 'generic_name' => 'Omeprazole', 'dosage' => '20mg', 'form' => 'Tablet', 'strength' => '20', 'price' => 90.00, 'stock_quantity' => 120],
        ];

        foreach ($medicines as $medicineData) {
            Medicine::firstOrCreate($medicineData);
        }
    }
}