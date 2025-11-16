<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';
    public $timestamps = false;

    protected $fillable = [
        'type',
        'created_at',
        'total_price',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    const TYPE_ONE_WAY = 'ONE_WAY';
    const TYPE_ROUND_TRIP = 'ROUND_TRIP';

    /**
     * Get the trip flights for this trip.
     */
    public function tripFlights()
    {
        return $this->hasMany(TripFlight::class, 'trip_id')->orderBy('position');
    }

    /**
     * Get the flights for this trip through trip_flights.
     */
    public function flights()
    {
        return $this->hasManyThrough(
            Flight::class,
            TripFlight::class,
            'trip_id',
            'id',
            'id',
            'flight_id'
        )->orderBy('trip_flights.position');
    }

    /**
     * Boot method to set default created_at.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trip) {
            if (empty($trip->created_at)) {
                $trip->created_at = now();
            }
        });
    }
}
