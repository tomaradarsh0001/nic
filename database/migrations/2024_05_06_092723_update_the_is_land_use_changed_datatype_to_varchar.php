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
        Schema::table('property_lease_detail_histories', function (Blueprint $table) {
            $table->string('is_land_use_changed')->change()->nullable();
            $table->string('new_is_land_use_changed')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_lease_detail_histories', function (Blueprint $table) {
            $table->boolean('is_land_use_changed')->change();
            $table->boolean('new_is_land_use_changed')->change();
        });
    }
};
