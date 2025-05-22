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
        Schema::table('current_lessee_details', function (Blueprint $table) {
            $table->string('unit')->after('area')->nullable();
            $table->string('area_in_sqm')->after('unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('current_lessee_details', function (Blueprint $table) {
            $table->dropColumn('unit');
            $table->dropColumn('area_in_sqm');
        });
    }
};
