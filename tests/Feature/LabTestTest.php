<?php

namespace Tests\Feature;

use App\Models\LabTest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabTestTest extends TestCase
{
    use RefreshDatabase;

    public function test_lab_tests_index_can_be_accessed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/lab_tests');
        $response->assertStatus(200);
    }

    public function test_lab_test_can_be_created(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/lab_tests', [
            'department' => 'Biochemistry',
            'sample_type' => 'Blood',
            'panel' => 'Liver Function',
            'test' => 'ALT',
            'code' => 'SGPT',
            'unit' => 'U/L',
            'result_type' => 'Numeric',
            'normal_range' => '7-56',
        ]);

        $response->assertRedirect('/lab_tests');
        $this->assertDatabaseHas('lab_tests', [
            'test' => 'ALT',
            'department' => 'Biochemistry',
        ]);
    }

    public function test_lab_test_requires_test_name(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/lab_tests', [
            'department' => 'Biochemistry',
            'sample_type' => 'Blood',
        ]);

        $response->assertSessionHasErrors('test');
    }

    public function test_lab_test_can_be_updated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $test = LabTest::factory()->create([
            'test' => 'Old Test',
            'department' => 'Old Dept',
            'code' => 'OLD001',
        ]);

        $response = $this->put("/lab_tests/{$test->id}", [
            'department' => 'New Dept',
            'sample_type' => 'Blood',
            'panel' => 'New Panel',
            'test' => 'New Test',
            'code' => 'OLD001', // Keep same code to avoid unique violation
            'result_type' => 'Numeric',
            'normal_range' => '0-100',
        ]);

        $response->assertRedirect(route('lab_tests.index'));
        $this->assertDatabaseHas('lab_tests', [
            'id' => $test->id,
            'test' => 'New Test',
        ]);
    }

    public function test_lab_test_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $test = LabTest::factory()->create();

        $response = $this->delete("/lab_tests/{$test->id}");

        $response->assertRedirect('/lab_tests');
        $this->assertDatabaseMissing('lab_tests', ['id' => $test->id]);
    }
}
