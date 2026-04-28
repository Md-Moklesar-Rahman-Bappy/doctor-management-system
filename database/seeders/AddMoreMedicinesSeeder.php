<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class AddMoreMedicinesSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            Medicine::create([
                'name' => 'Medicine ' . $i,
                'generic_name' => 'Generic ' . $i,
                'dosage' => rand(100, 500) . 'mg',
                'form' => 'Tablet',
                'strength' => rand(100, 500),
                'price' => rand(10, 100),
                'stock_quantity' => rand(50, 200),
                'description' => 'Test medicine'
            ]);
        }
        
        $this->command->info('Created 100 test medicines');
    }
}