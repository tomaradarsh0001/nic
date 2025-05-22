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
        Schema::create('old_colonies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('zone_code')->nullable();
            $table->string('dealing_section_code')->nullable();
            $table->string('land_rate',20)->nullable();
            $table->string('land_rate_unit')->nullable();
            $table->string('land_type')->nullable();
            $table->string('property_type')->nullable();
            $table->string('related_colonies')->nullable();
            $table->string('colony_stats')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_colonies');
    }
};
