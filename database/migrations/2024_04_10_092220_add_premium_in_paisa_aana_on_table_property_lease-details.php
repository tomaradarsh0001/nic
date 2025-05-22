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
            $table->string('premium_in_paisa')->after('premium')->nullable();
            $table->string('premium_in_aana')->after('premium_in_paisa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_lease_details', function (Blueprint $table) {
            $table->dropColumn('premium_in_paisa');
            $table->dropColumn('premium_in_aana');
        });
    }
};
