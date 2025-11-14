<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Trip;
use App\Models\Flight;
use App\Models\TripFlight;
use App\Models\Airline;
use App\Models\Airport;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTripApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_one_way_trip(): void
    {
        // Create test data
        $airline = Airline::factory()->create();
        $departure = Airport::factory()->create();
        $arrival = Airport::factory()->create();

        $flight = Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $departure->code,
            'arrival_airport' => $arrival->code,
            'price' => 273.23,
        ]);

        $response = $this->postJson('/api/book/trip', [
            'flight_id' => $flight->id,
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                 ])
                 ->assertJsonStructure([
                     'success',
                     'trip_id',
                 ]);

        // Verify database
        $this->assertDatabaseHas('trips', [
            'type' => Trip::TYPE_ONE_WAY,
            'total_price' => 273.23,
        ]);

        $trip = Trip::first();

        $this->assertDatabaseHas('trip_flights', [
            'trip_id' => $trip->id,
            'flight_id' => $flight->id,
            'position' => 1,
            'price' => 273.23,
        ]);

        $this->assertEquals(1, TripFlight::count());
    }

    public function test_book_round_trip(): void
    {
        // Create test data
        $airline = Airline::factory()->create();
        $yul = Airport::factory()->create(['code' => 'YUL']);
        $yvr = Airport::factory()->create(['code' => 'YVR']);

        $outboundFlight = Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $yul->code,
            'arrival_airport' => $yvr->code,
            'price' => 273.23,
        ]);

        $returnFlight = Flight::factory()->create([
            'airline_code' => $airline->code,
            'departure_airport' => $yvr->code,
            'arrival_airport' => $yul->code,
            'price' => 220.63,
        ]);

        $response = $this->postJson('/api/book/trip', [
            'flight_id' => $outboundFlight->id,
            'return_flight_id' => $returnFlight->id,
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                 ]);

        // Verify database
        $this->assertDatabaseHas('trips', [
            'type' => Trip::TYPE_ROUND_TRIP,
            'total_price' => 493.86, // 273.23 + 220.63
        ]);

        $trip = Trip::first();

        $this->assertDatabaseHas('trip_flights', [
            'trip_id' => $trip->id,
            'flight_id' => $outboundFlight->id,
            'position' => 1,
        ]);

        $this->assertDatabaseHas('trip_flights', [
            'trip_id' => $trip->id,
            'flight_id' => $returnFlight->id,
            'position' => 2,
        ]);

        $this->assertEquals(2, TripFlight::count());
    }

    public function test_book_trip_requires_valid_flight_id(): void
    {
        $response = $this->postJson('/api/book/trip', [
            'flight_id' => 99999,
        ]);

        $response->assertStatus(422);
    }

    public function test_book_trip_requires_flight_id(): void
    {
        $response = $this->postJson('/api/book/trip', []);

        $response->assertStatus(422);
    }
}
