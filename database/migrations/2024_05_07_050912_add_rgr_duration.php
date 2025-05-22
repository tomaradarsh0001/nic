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
            $table->string('rgr_duration')->nullable()->after('new_start_date_of_gr');
            $table->string('new_rgr_duration')->nullable()->after('rgr_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_lease_detail_histories', function (Blueprint $table) {
            //
        });
    }
};
