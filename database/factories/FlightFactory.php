<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        $departureAt = $this->faker->dateTimeBetween('now', '+30 days');
        $arrivalAt = (clone $departureAt)->modify('+' . $this->faker->numberBetween(2, 8) . ' hours');

        return [
            'airline_code' => Airline::factory(),
            'number' => $this->faker->numberBetween(100, 999),
            'departure_airport' => Airport::factory(),
            'arrival_airport' => Airport::factory(),
            'departure_at' => $departureAt,
            'arrival_at' => $arrivalAt,
            'price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
