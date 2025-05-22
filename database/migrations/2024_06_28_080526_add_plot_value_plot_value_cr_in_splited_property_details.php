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
        Schema::table('splited_property_details', function (Blueprint $table) {
            $table->string('plot_value')->nullable()->after('area_in_sqm');
            $table->string('plot_value_cr')->nullable()->after('plot_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('splited_property_details', function (Blueprint $table) {
            $table->dropColumn('plot_value');
            $table->dropColumn('plot_value_cr');
        });
    }
};
