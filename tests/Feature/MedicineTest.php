<?php

namespace Tests\Feature;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicineTest extends TestCase
{
    use RefreshDatabase;

    public function test_medicines_index_can_be_accessed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/medicines');
        $response->assertStatus(200);
    }

    public function test_medicine_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/medicines', [
            'brand_name' => 'Paracetamol',
            'generic_name' => 'Acetaminophen',
            'dosage_type' => 'Tablet',
            'strength' => '500mg',
            'company_name' => 'GSK',
            'package_mark' => 'Strip',
        ]);

        $response->assertRedirect('/medicines');
        $this->assertDatabaseHas('medicines', [
            'brand_name' => 'Paracetamol',
            'generic_name' => 'Acetaminophen',
        ]);
    }

    public function test_medicine_requires_brand_name(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/medicines', [
            'generic_name' => 'Acetaminophen',
            'dosage_type' => 'Tablet',
        ]);

        $response->assertSessionHasErrors('brand_name');
    }

    public function test_medicine_can_be_updated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $medicine = Medicine::factory()->create([
            'brand_name' => 'Old Name',
            'dosage_type' => 'Tablet',
        ]);

        $response = $this->put("/medicines/{$medicine->id}", [
            'brand_name' => 'New Name',
            'generic_name' => 'New Generic',
            'dosage_type' => 'Capsule',
            'strength' => '250mg',
        ]);

        $response->assertRedirect('/medicines');
        $this->assertDatabaseHas('medicines', [
            'id' => $medicine->id,
            'brand_name' => 'New Name',
        ]);
    }

    public function test_medicine_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $medicine = Medicine::factory()->create();

        $response = $this->delete("/medicines/{$medicine->id}");

        $response->assertRedirect('/medicines');
        $this->assertDatabaseMissing('medicines', ['id' => $medicine->id]);
    }
}
