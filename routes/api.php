<?php

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AirlineController;
use App\Http\Controllers\Api\AirportController;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\TripController;

Route::get('/airlines', [AirlineController::class, 'index']);
Route::get('/airports', [AirportController::class, 'index']);
Route::get('/flights', [FlightController::class, 'index']);
Route::get('/trips', [TripController::class, 'index']);
Route::post('/book/trip', [TripController::class, 'book']);
