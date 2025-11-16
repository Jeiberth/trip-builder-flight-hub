<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->char('airline_code', 2);
            $table->string('number', 10);
            $table->char('departure_airport', 3);
            $table->char('arrival_airport', 3);
            $table->timestamp('departure_at');
            $table->timestamp('arrival_at');
            $table->decimal('price', 10, 2);

            $table->foreign('airline_code')->references('code')->on('airlines');
            $table->foreign('departure_airport')->references('code')->on('airports');
            $table->foreign('arrival_airport')->references('code')->on('airports');

            $table->unique(['airline_code', 'number', 'departure_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
