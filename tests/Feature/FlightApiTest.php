<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airport;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_one_way_flights(): void
    {
        // Create test data
        $airline = Airline::factory()->create(['code' => 'AC']);
        $yul = Airport::factory()->create(['code' => 'YUL']);
        $yvr = Airport::factory()->create(['code' => 'YVR']);

        $departureDate = Carbon::tomorrow();

        Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $yul->code,
            'arrival_airport' => $yvr->code,
            'departure_at' => $departureDate->copy()->setTime(7, 35),
            'arrival_at' => $departureDate->copy()->setTime(10, 5),
        ]);

        Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $yul->code,
            'arrival_airport' => $yvr->code,
            'departure_at' => $departureDate->copy()->setTime(14, 0),
            'arrival_at' => $departureDate->copy()->setTime(16, 30),
        ]);

        // Different date - should not be returned
        Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $yul->code,
            'arrival_airport' => $yvr->code,
            'departure_at' => $departureDate->copy()->addDay()->setTime(7, 35),
            'arrival_at' => $departureDate->copy()->addDay()->setTime(10, 5),
        ]);

        $response = $this->getJson('/api/flights?' . http_build_query([
            'departure_airport' => 'YUL',
            'arrival_airport' => 'YVR',
            'departure_at' => $departureDate->format('Y-m-d'),
        ]));

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    public function test_get_round_trip_flights(): void
    {
        // Create test data
        $airline = Airline::factory()->create(['code' => 'AC']);
        $yul = Airport::factory()->create(['code' => 'YUL']);
        $yvr = Airport::factory()->create(['code' => 'YVR']);

        $departureDate = Carbon::tomorrow();
        $returnDate = $departureDate->copy()->addDays(3);

        // Outbound flight
        Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $yul->code,
            'arrival_airport' => $yvr->code,
            'departure_at' => $departureDate->copy()->setTime(7, 35),
            'arrival_at' => $departureDate->copy()->setTime(10, 5),
        ]);

        // Return flight
        Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $yvr->code,
            'arrival_airport' => $yul->code,
            'departure_at' => $returnDate->copy()->setTime(11, 30),
            'arrival_at' => $returnDate->copy()->setTime(19, 11),
        ]);

        $response = $this->getJson('/api/flights?' . http_build_query([
            'departure_airport' => 'YUL',
            'arrival_airport' => 'YVR',
            'departure_at' => $departureDate->format('Y-m-d'),
            'return_at' => $returnDate->format('Y-m-d'),
        ]));

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    public function test_filter_flights_by_airline(): void
    {
        // Create test data
        $airCanada = Airline::factory()->create(['code' => 'AC']);
        $westJet = Airline::factory()->create(['code' => 'WS']);
        $yul = Airport::factory()->create(['code' => 'YUL']);
        $yvr = Airport::factory()->create(['code' => 'YVR']);

        $departureDate = Carbon::tomorrow();

        Flight::factory()->create([
            'airline_code' => $airCanada->code,
            'departure_airport' => $yul->code,
            'arrival_airport' => $yvr->code,
            'departure_at' => $departureDate->copy()->setTime(7, 35),
            'arrival_at' => $departureDate->copy()->setTime(10, 5),
        ]);

        Flight::factory()->create([
            'airline_code' => $westJet->code,
            'departure_airport' => $yul->code,
            'arrival_airport' => $yvr->code,
            'departure_at' => $departureDate->copy()->setTime(14, 0),
            'arrival_at' => $departureDate->copy()->setTime(16, 30),
        ]);

        $response = $this->getJson('/api/flights?' . http_build_query([
            'departure_airport' => 'YUL',
            'arrival_airport' => 'YVR',
            'departure_at' => $departureDate->format('Y-m-d'),
            'airline' => 'AC',
        ]));

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['airline_code' => 'AC']);
    }

    public function test_flights_requires_validation(): void
    {
        $response = $this->getJson('/api/flights');

        $response->assertStatus(422);
    }
}
