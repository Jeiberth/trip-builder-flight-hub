<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights';
    public $timestamps = false;

    protected $fillable = [
        'airline_code',
        'number',
        'departure_airport',
        'arrival_airport',
        'departure_at',
        'arrival_at',
        'price',
    ];

    protected $casts = [
        'departure_at' => 'datetime',
        'arrival_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Get the airline that owns the flight.
     */
    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_code', 'code');
    }

    /**
     * Get the departure airport.
     */
    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport', 'code');
    }

    /**
     * Get the arrival airport.
     */
    public function arrivalAirport()
    {
        return $this->belongsTo(Airport::class, 'arrival_airport', 'code');
    }

    /**
     * Get the trip flights for this flight.
     */
    public function tripFlights()
    {
        return $this->hasMany(TripFlight::class, 'flight_id');
    }
}
