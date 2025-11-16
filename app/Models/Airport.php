<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $table = 'airports';
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'city_code',
        'name',
        'city',
        'country_code',
        'region_code',
        'latitude',
        'longitude',
        'timezone',
        'utc_offset',
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'utc_offset' => 'integer',
    ];

    /**
     * Get the flights departing from this airport.
     */
    public function departingFlights()
    {
        return $this->hasMany(Flight::class, 'departure_airport', 'code');
    }

    /**
     * Get the flights arriving at this airport.
     */
    public function arrivingFlights()
    {
        return $this->hasMany(Flight::class, 'arrival_airport', 'code');
    }
}
