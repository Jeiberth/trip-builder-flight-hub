<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->char('code', 3)->primary();
            $table->char('city_code', 3);
            $table->string('name', 150);
            $table->string('city', 100);
            $table->char('country_code', 2);
            $table->string('region_code', 10)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('timezone', 50);
            $table->smallInteger('utc_offset');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
