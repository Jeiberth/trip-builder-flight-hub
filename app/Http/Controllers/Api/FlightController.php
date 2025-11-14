<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FlightController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'departure_airport' => 'required|string|size:3',
            'arrival_airport' => 'required|string|size:3',
            'departure_at' => 'required|date',
            'return_at' => 'nullable|date',
            'airline' => 'nullable|string|size:2',
        ]);

        $departureAirport = $validated['departure_airport'];
        $arrivalAirport = $validated['arrival_airport'];
        $departureDate = Carbon::parse($validated['departure_at'])->format('Y-m-d');
        $returnAt = $validated['return_at'] ?? null;
        $airline = $validated['airline'] ?? null;

        $query = Flight::query();

        if ($returnAt === null) {
            // One-way flight search
            $query->where('departure_airport', $departureAirport)
                  ->where('arrival_airport', $arrivalAirport)
                  ->whereDate('departure_at', $departureDate);
        } else {
            // Round-trip flight search
            $returnDate = Carbon::parse($returnAt)->format('Y-m-d');

            $query->where(function ($q) use ($departureAirport, $arrivalAirport, $departureDate, $returnDate) {
                // Outbound flights
                $q->where(function ($outbound) use ($departureAirport, $arrivalAirport, $departureDate) {
                    $outbound->where('departure_airport', $departureAirport)
                             ->where('arrival_airport', $arrivalAirport)
                             ->whereDate('departure_at', $departureDate);
                })
                // Return flights
                ->orWhere(function ($inbound) use ($arrivalAirport, $departureAirport, $returnDate) {
                    $inbound->where('departure_airport', $arrivalAirport)
                            ->where('arrival_airport', $departureAirport)
                            ->whereDate('departure_at', $returnDate);
                });
            });
        }

        // Apply airline filter if provided
        if ($airline) {
            $query->where('airline_code', $airline);
        }

        $flights = $query->with(['airline', 'departureAirport', 'arrivalAirport'])
                         ->orderBy('departure_at')
                         ->get();

        return response()->json($flights);
    }
}
