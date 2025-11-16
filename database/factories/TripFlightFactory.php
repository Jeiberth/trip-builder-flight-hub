<?php

namespace Database\Factories;

use App\Models\TripFlight;
use App\Models\Trip;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFlightFactory extends Factory
{
    protected $model = TripFlight::class;

    public function definition(): array
    {
        return [
            'trip_id' => Trip::factory(),
            'flight_id' => Flight::factory(),
            'position' => 1,
            'price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
