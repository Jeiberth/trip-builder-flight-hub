<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement([Trip::TYPE_ONE_WAY, Trip::TYPE_ROUND_TRIP]),
            'created_at' => now(),
            'total_price' => $this->faker->randomFloat(2, 100, 2000),
        ];
    }

    public function oneWay(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Trip::TYPE_ONE_WAY,
        ]);
    }

    public function roundTrip(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Trip::TYPE_ROUND_TRIP,
        ]);
    }
}
