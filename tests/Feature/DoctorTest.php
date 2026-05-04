<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/doctors', [
            'name' => 'Dr. John Smith',
            'license' => 'DOC-12345',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'degrees' => ['MD', 'PhD'],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('doctors', [
            'name' => 'Dr. John Smith',
            'email' => 'john@example.com',
        ]);
    }

    public function test_doctor_requires_name(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/doctors', [
            'email' => 'john@example.com',
            'phone' => '1234567890',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_doctor_email_must_be_unique(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Doctor::create([
            'name' => 'Existing Doctor',
            'email' => 'existing@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'user_id' => $user->id,
        ]);

        $response = $this->post('/doctors', [
            'name' => 'New Doctor',
            'email' => 'existing@example.com',
            'phone' => '0987654321',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
