<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Trip;
use App\Models\Flight;
use App\Models\TripFlight;
use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TripApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_trips(): void
    {
        // Create test data
        $airline = Airline::factory()->create();
        $airport1 = Airport::factory()->create();
        $airport2 = Airport::factory()->create();

        $flight = Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $airport1->code,
            'arrival_airport' => $airport2->code,
        ]);

        $trip = Trip::factory()->create();

        TripFlight::factory()->create([
            'trip_id' => $trip->id,
            'flight_id' => $flight->id,
            'position' => 1,
        ]);

        $response = $this->getJson('/api/trips');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonStructure([
                     '*' => [
                         'id',
                         'type',
                         'created_at',
                         'total_price',
                         'trip_flights' => [
                             '*' => [
                                 'id',
                                 'trip_id',
                                 'flight_id',
                                 'position',
                                 'price',
                                 'flight',
                             ]
                         ]
                     ]
                 ]);
    }

    public function test_get_trips_returns_empty_array_when_none_exist(): void
    {
        $response = $this->getJson('/api/trips');

        $response->assertStatus(200)
                 ->assertJson([]);
    }
}
