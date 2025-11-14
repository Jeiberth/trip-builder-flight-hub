<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\TripFlight;
use App\Models\Flight;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function index(): JsonResponse
    {
        $trips = Trip::with(['tripFlights.flight.airline',
                             'tripFlights.flight.departureAirport',
                             'tripFlights.flight.arrivalAirport'])
                     ->get();

        return response()->json($trips);
    }

    public function book(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'return_flight_id' => 'nullable|exists:flights,id',
        ]);

        try {
            DB::beginTransaction();

            $outboundFlight = Flight::findOrFail($validated['flight_id']);
            $returnFlightId = $validated['return_flight_id'] ?? null;

            // Determine trip type
            $tripType = $returnFlightId ? Trip::TYPE_ROUND_TRIP : Trip::TYPE_ONE_WAY;

            // Calculate total price
            $totalPrice = $outboundFlight->price;
            if ($returnFlightId) {
                $returnFlight = Flight::findOrFail($returnFlightId);
                $totalPrice += $returnFlight->price;
            }

            // Create trip
            $trip = Trip::create([
                'type' => $tripType,
                'total_price' => $totalPrice,
            ]);

            // Create outbound trip flight
            TripFlight::create([
                'trip_id' => $trip->id,
                'flight_id' => $outboundFlight->id,
                'position' => 1,
                'price' => $outboundFlight->price,
            ]);

            // Create return trip flight if exists
            if ($returnFlightId) {
                TripFlight::create([
                    'trip_id' => $trip->id,
                    'flight_id' => $returnFlightId,
                    'position' => 2,
                    'price' => $returnFlight->price,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'trip_id' => $trip->id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to book trip: ' . $e->getMessage(),
            ], 500);
        }
    }
}
