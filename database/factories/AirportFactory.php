<?php

namespace Database\Factories;

use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

class AirportFactory extends Factory
{
    protected $model = Airport::class;

    public function definition(): array
    {
        $code = strtoupper($this->faker->unique()->lexify('???'));

        return [
            'code' => $code,
            'city_code' => $code,
            'name' => $this->faker->city() . ' International Airport',
            'city' => $this->faker->city(),
            'country_code' => strtoupper($this->faker->countryCode()),
            'region_code' => strtoupper($this->faker->lexify('??')),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'timezone' => $this->faker->timezone(),
            'utc_offset' => $this->faker->numberBetween(-12, 14),
        ];
    }
}
