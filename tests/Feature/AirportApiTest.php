<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Airport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AirportApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_airports(): void
    {
        // Create test airports
        Airport::factory()->count(5)->create();

        $response = $this->getJson('/api/airports');

        $response->assertStatus(200)
                 ->assertJsonCount(5)
                 ->assertJsonStructure([
                     '*' => [
                         'code',
                         'city_code',
                         'name',
                         'city',
                         'country_code',
                         'region_code',
                         'latitude',
                         'longitude',
                         'timezone',
                         'utc_offset',
                     ]
                 ]);
    }

    public function test_get_airports_returns_empty_array_when_none_exist(): void
    {
        $response = $this->getJson('/api/airports');

        $response->assertStatus(200)
                 ->assertJson([]);
    }
}
