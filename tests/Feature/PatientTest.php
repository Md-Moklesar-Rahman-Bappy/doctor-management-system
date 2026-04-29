<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/patients', [
            'patient_name' => 'John Doe',
            'age' => 30,
            'sex' => 'male',
            'date' => '2026-04-29',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('patients', [
            'patient_name' => 'John Doe',
            'age' => 30,
        ]);
    }

    public function test_patient_requires_name(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/patients', [
            'age' => 30,
            'sex' => 'male',
        ]);

        $response->assertSessionHasErrors('patient_name');
    }

    public function test_patient_can_be_viewed(): void
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/patients/{$patient->id}");
        $response->assertStatus(200);
        $response->assertSee($patient->patient_name);
    }
}
