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
        Schema::table('splited_property_detail_histories', function (Blueprint $table) {
            $table->string('unit')->after('new_current_area')->nullable();
            $table->string('new_unit')->after('unit')->nullable();
            $table->string('area_in_sqm')->after('new_unit')->nullable();
            $table->string('new_area_in_sqm')->after('area_in_sqm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('splited_property_detail_histories', function (Blueprint $table) {
            $table->dropColumn('unit');
            $table->dropColumn('new_unit');
            $table->dropColumn('area_in_sqm');
            $table->dropColumn('new_area_in_sqm');
        });
    }
};
