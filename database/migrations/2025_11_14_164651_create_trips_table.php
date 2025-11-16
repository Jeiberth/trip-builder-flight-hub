<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->timestamp('created_at')->useCurrent();
            $table->decimal('total_price', 10, 2)->default(0);

            // $table->check("type IN ('ONE_WAY', 'ROUND_TRIP')");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
