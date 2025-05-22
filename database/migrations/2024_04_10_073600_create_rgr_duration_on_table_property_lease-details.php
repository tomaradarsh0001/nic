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
        Schema::table('property_lease_details', function (Blueprint $table) {
            $table->string('rgr_duration')->after('start_date_of_gr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_lease_details', function (Blueprint $table) {
            $table->dropColumn('rgr_duration');
        });
    }
};
