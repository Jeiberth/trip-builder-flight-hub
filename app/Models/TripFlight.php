<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripFlight extends Model
{
    use HasFactory;

    protected $table = 'trip_flights';
    public $timestamps = false;

    protected $fillable = [
        'trip_id',
        'flight_id',
        'position',
        'price',
    ];

    protected $casts = [
        'position' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Get the trip that owns the trip flight.
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    /**
     * Get the flight that owns the trip flight.
     */
    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }
}
