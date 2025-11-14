<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use Carbon\Carbon;

class DatabaseSeeder_backup extends Seeder
{
    public function run(): void
    {
        // Create Airlines
        $airCanada = Airline::create([
            'code' => 'AC',
            'name' => 'Air Canada',
        ]);

        Airline::create([
            'code' => 'WS',
            'name' => 'WestJet',
        ]);

        // Create Airports
        $yul = Airport::create([
            'code' => 'YUL',
            'city_code' => 'YMQ',
            'name' => 'Pierre Elliott Trudeau International',
            'city' => 'Montreal',
            'country_code' => 'CA',
            'region_code' => 'QC',
            'latitude' => 45.457714,
            'longitude' => -73.749908,
            'timezone' => 'America/Montreal',
            'utc_offset' => -5,
        ]);

        $yvr = Airport::create([
            'code' => 'YVR',
            'city_code' => 'YVR',
            'name' => 'Vancouver International',
            'city' => 'Vancouver',
            'country_code' => 'CA',
            'region_code' => 'BC',
            'latitude' => 49.194698,
            'longitude' => -123.179192,
            'timezone' => 'America/Vancouver',
            'utc_offset' => -8,
        ]);

        $yyz = Airport::create([
            'code' => 'YYZ',
            'city_code' => 'YTO',
            'name' => 'Toronto Pearson International',
            'city' => 'Toronto',
            'country_code' => 'CA',
            'region_code' => 'ON',
            'latitude' => 43.677223,
            'longitude' => -79.630556,
            'timezone' => 'America/Toronto',
            'utc_offset' => -5,
        ]);

        // Create sample flights for the next 7 days
        $today = Carbon::today();

        for ($day = 0; $day < 7; $day++) {
            $date = $today->copy()->addDays($day);

            // YUL to YVR
            Flight::create([
                'airline_code' => 'AC',
                'number' => '301',
                'departure_airport' => 'YUL',
                'arrival_airport' => 'YVR',
                'departure_at' => $date->copy()->setTime(7, 35),
                'arrival_at' => $date->copy()->setTime(10, 5),
                'price' => 273.23,
            ]);

            // YVR to YUL
            Flight::create([
                'airline_code' => 'AC',
                'number' => '302',
                'departure_airport' => 'YVR',
                'arrival_airport' => 'YUL',
                'departure_at' => $date->copy()->setTime(11, 30),
                'arrival_at' => $date->copy()->setTime(19, 11),
                'price' => 220.63,
            ]);

            // YUL to YYZ
            Flight::create([
                'airline_code' => 'AC',
                'number' => '401',
                'departure_airport' => 'YUL',
                'arrival_airport' => 'YYZ',
                'departure_at' => $date->copy()->setTime(9, 0),
                'arrival_at' => $date->copy()->setTime(10, 30),
                'price' => 150.00,
            ]);

            // YYZ to YUL
            Flight::create([
                'airline_code' => 'AC',
                'number' => '402',
                'departure_airport' => 'YYZ',
                'arrival_airport' => 'YUL',
                'departure_at' => $date->copy()->setTime(15, 0),
                'arrival_at' => $date->copy()->setTime(16, 30),
                'price' => 145.00,
            ]);

            // WestJet flights
            Flight::create([
                'airline_code' => 'WS',
                'number' => '501',
                'departure_airport' => 'YUL',
                'arrival_airport' => 'YVR',
                'departure_at' => $date->copy()->setTime(14, 0),
                'arrival_at' => $date->copy()->setTime(16, 30),
                'price' => 250.00,
            ]);

            Flight::create([
                'airline_code' => 'WS',
                'number' => '502',
                'departure_airport' => 'YVR',
                'arrival_airport' => 'YUL',
                'departure_at' => $date->copy()->setTime(8, 0),
                'arrival_at' => $date->copy()->setTime(15, 45),
                'price' => 210.00,
            ]);
        }
    }
}
