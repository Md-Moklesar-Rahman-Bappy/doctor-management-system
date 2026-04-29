<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrescriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_prescription_requires_patient(): void
    {
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->post('/prescriptions', [
            'doctor_id' => $doctor->id,
            'problem' => ['Headache'],
        ]);

        $response->assertSessionHasErrors('patient_id');
    }

    public function test_prescription_can_be_created(): void
    {
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create(['user_id' => $user->id]);
        $patient = Patient::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->post('/prescriptions', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'problem' => ['Fever', 'Cough'],
            'tests' => ['Blood Test'],
            'medicines' => [
                ['name' => 'Paracetamol', 'dosage' => '500mg', 'duration' => '5 days']
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('prescriptions', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
        ]);
    }

    public function test_prescription_can_be_viewed(): void
    {
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create(['user_id' => $user->id]);
        $patient = Patient::factory()->create(['user_id' => $user->id]);
        $prescription = Prescription::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
        ]);

        $response = $this->actingAs($user)->get("/prescriptions/{$prescription->id}");
        $response->assertStatus(200);
        $response->assertSee($patient->patient_name);
    }
}
