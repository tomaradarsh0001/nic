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
        Schema::table('property_revivised_ground_rent', function (Blueprint $table) {
            $table->decimal('lndo_rgr_per_annum', total: 12, places: 2)->after('circle_land_value')->nullable();
            $table->decimal('circle_rgr_per_annum', total: 12, places: 2)->after('lndo_rgr_per_annum')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->enum('calculated_on_rate', ['L', 'C'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_revivised_ground_rent', function (Blueprint $table) {
            $table->dropColumn('lndo_rgr_per_annum');
            $table->dropColumn('circle_rgr_per_annum');
            $table->dropColumn('no_of_days');
            $table->dropColumn('calculated_on_rate');
        });
    }
};
