<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('circle_rate_colony_wise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('old_colony_id');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->decimal('residential_land_rate', total: 12, places: 2)->nullable();
            $table->decimal('commercial_land_rate', total: 12, places: 2)->nullable();
            $table->decimal('institutional_land_rate', total: 12, places: 2)->nullable();
            $table->decimal('industrial_land_rate', total: 12, places: 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circle_rate_colony_wise');
    }
};
