<?php

namespace Tests\Feature;

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PatientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_patient()
    {
        $response = $this->postJson('/api/v1/add-patients', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'medical_history' => 'Initial checkup',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'age',
                    'medical_history',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('patients', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
        ]);
    }

    public function test_store_patient_validation()
    {
        $response = $this->postJson('/api/v1/add-patients', [
            'first_name' => '',
            'last_name' => '',
            'age' => 'invalid',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'age']);
    }

    public function test_show_patient()
    {
        $patient = Patient::factory()->create();

        $response = $this->getJson("/api/v1/patients/{$patient->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $patient->id,
                    'first_name' => $patient->first_name,
                    'last_name' => $patient->last_name,
                ],
            ]);
    }

    public function test_show_non_existent_patient()
    {
        $response = $this->getJson('/api/v1/patients/9999');

        $response->assertStatus(404)
            ->assertJson([
                'data' => null,
                'errors' => [
                    [
                        'code' => 'PATIENT_NOT_FOUND',
                        'message' => 'Patient not found',
                    ],
                ],
            ]);
    }

    public function test_search_patients()
    {
        $patient1 = Patient::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
        ]);

        $patient2 = Patient::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'age' => 25,
        ]);

        $response = $this->getJson('/api/v1/search-patients?first_name=John');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.first_name', 'John');

        $response = $this->getJson('/api/v1/search-patients?last_name=Doe');
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');

        $response = $this->getJson('/api/v1/search-patients?first_name=NonExistent');
        $response->assertStatus(200)
            ->assertJson(['data' => null]);
    }

    public function test_add_medical_history()
    {
        $patient = Patient::factory()->create([
            'medical_history' => 'Initial checkup',
        ]);

        $response = $this->postJson("/api/v1/patients/add-medical-history/{$patient->id}", [
            'medical_history' => 'Follow-up visit',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.medical_history', "Initial checkup\nFollow-up visit");

        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'medical_history' => "Initial checkup\nFollow-up visit",
        ]);
    }

    public function test_add_empty_medical_history()
    {
        $patient = Patient::factory()->create();

        $response = $this->postJson("/api/v1/patients/add-medical-history/{$patient->id}", [
            'medical_history' => '',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'data' => null,
                'errors' => [
                    [
                        'code' => 'MEDICAL_HISTORY_REQUIRED',
                        'message' => 'Medical history data is required',
                    ],
                ],
            ]);
    }

    public function test_add_medical_history_to_non_existent_patient()
    {
        $response = $this->postJson('/api/v1/patients/add-medical-history/9999', [
            'medical_history' => 'Some history',
        ]);

        $response->assertStatus(404);
    }
}