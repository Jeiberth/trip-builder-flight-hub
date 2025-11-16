<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Airline;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AirlineApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_airlines(): void
    {
        // Create test airlines
        Airline::factory()->count(3)->create();

        $response = $this->getJson('/api/airlines');

        $response->assertStatus(200)
                 ->assertJsonCount(3)
                 ->assertJsonStructure([
                     '*' => [
                         'code',
                         'name',
                     ]
                 ]);
    }

    public function test_get_airlines_returns_empty_array_when_none_exist(): void
    {
        $response = $this->getJson('/api/airlines');

        $response->assertStatus(200)
                 ->assertJson([]);
    }
}
