<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. Airlines ---
        $airlinesData = [
            ['code' => 'AC', 'name' => 'Air Canada'],
            ['code' => 'WS', 'name' => 'WestJet'],
            ['code' => 'DL', 'name' => 'Delta Airlines'],
            ['code' => 'UA', 'name' => 'United Airlines'],
            ['code' => 'AA', 'name' => 'American Airlines'],
            ['code' => 'BA', 'name' => 'British Airways'],
        ];

        $airlines = [];
        foreach ($airlinesData as $data) {
            $airlines[$data['code']] = Airline::create($data);
        }

        // --- 2. Airports ---
        $airportsData = [
            ['code'=>'YUL','city_code'=>'YMQ','name'=>'Pierre Elliott Trudeau International','city'=>'Montreal','country_code'=>'CA','region_code'=>'QC','latitude'=>45.457714,'longitude'=>-73.749908,'timezone'=>'America/Montreal','utc_offset'=>-5],
            ['code'=>'YVR','city_code'=>'YVR','name'=>'Vancouver International','city'=>'Vancouver','country_code'=>'CA','region_code'=>'BC','latitude'=>49.194698,'longitude'=>-123.179192,'timezone'=>'America/Vancouver','utc_offset'=>-8],
            ['code'=>'YYZ','city_code'=>'YTO','name'=>'Toronto Pearson International','city'=>'Toronto','country_code'=>'CA','region_code'=>'ON','latitude'=>43.677223,'longitude'=>-79.630556,'timezone'=>'America/Toronto','utc_offset'=>-5],
            ['code'=>'YEG','city_code'=>'YEG','name'=>'Edmonton International','city'=>'Edmonton','country_code'=>'CA','region_code'=>'AB','latitude'=>53.309722,'longitude'=>-113.580556,'timezone'=>'America/Edmonton','utc_offset'=>-7],
            ['code'=>'CYC','city_code'=>'YYC','name'=>'Calgary International','city'=>'Calgary','country_code'=>'CA','region_code'=>'AB','latitude'=>51.113888,'longitude'=>-114.020556,'timezone'=>'America/Edmonton','utc_offset'=>-7],
            ['code'=>'CYZ','city_code'=>'YYZ','name'=>'Toronto Pearson International','city'=>'Toronto','country_code'=>'CA','region_code'=>'ON','latitude'=>43.677223,'longitude'=>-79.630556,'timezone'=>'America/Toronto','utc_offset'=>-5],
            ['code'=>'CUL','city_code'=>'YUL','name'=>'Montreal Trudeau','city'=>'Montreal','country_code'=>'CA','region_code'=>'QC','latitude'=>45.457714,'longitude'=>-73.749908,'timezone'=>'America/Montreal','utc_offset'=>-5],
        ];

        $airports = [];
        foreach ($airportsData as $data) {
            $airports[$data['code']] = Airport::create($data);
        }

        // --- 3. Flights ---
        $today = Carbon::today();

        // For each of the next 7 days
        for ($day = 0; $day < 30; $day++) {
            $date = $today->copy()->addDays($day);

            foreach ($airlines as $airlineCode => $airline) {
                // Each airline flies between random airports 3-5 times a day
                $airportCodes = array_keys($airports);
                shuffle($airportCodes);

                for ($i = 0; $i < min(5, count($airportCodes) - 1); $i++) {
                    $departure = $airportCodes[$i];
                    $arrival = $airportCodes[$i + 1];

                    // Random departure hour between 6 AM and 10 PM
                    $depHour = rand(6, 22);
                    $depMinute = rand(0, 59);

                    // Random flight duration between 1 and 5 hours
                    $durationHours = rand(1, 5);
                    $durationMinutes = rand(0, 59);

                    $departureTime = $date->copy()->setTime($depHour, $depMinute);
                    $arrivalTime = $departureTime->copy()->addHours($durationHours)->addMinutes($durationMinutes);

                    // Random price between 100 and 600
                    $price = rand(10000, 60000) / 100;

                    // Random flight number (3 digits)
                    $flightNumber = rand(100, 999);

                    Flight::create([
                        'airline_code' => $airlineCode,
                        'number' => $flightNumber,
                        'departure_airport' => $departure,
                        'arrival_airport' => $arrival,
                        'departure_at' => $departureTime,
                        'arrival_at' => $arrivalTime,
                        'price' => $price,
                    ]);
                }
            }
        }
    }
}
