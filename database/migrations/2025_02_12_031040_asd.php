<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->float('distX1');
            $table->float('distX2');
            $table->float('distY1');
            $table->float('distY2');
            $table->integer('moistureAnalog');
            $table->boolean('moistureDigital');
            $table->float('maxTemp');
            $table->boolean('relayState');
            $table->json('heatmap');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
