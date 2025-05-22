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
        Schema::create('property_revivised_ground_rent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id');
            $table->string('property_area_in_sqm');
            $table->date('from_date');
            $table->date('till_date');
            $table->decimal('lndo_land_rate', total: 12, places: 2)->nullable();
            $table->decimal('circle_land_rate', total: 12, places: 2)->nullable();
            $table->string('lndo_land_rate_period')->nullable();
            $table->string('circle_land_rate_period')->nullable();
            $table->decimal('lndo_land_value', total: 12, places: 2)->nullable();
            $table->decimal('circle_land_value', total: 12, places: 2)->nullable();
            $table->decimal('lndo_rgr', total: 12, places: 2)->nullable();
            $table->decimal('circle_rgr', total: 12, places: 2)->nullable();
            $table->boolean('is_re_calculated')->default(false);
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_revivised_ground_rent');
    }
};
