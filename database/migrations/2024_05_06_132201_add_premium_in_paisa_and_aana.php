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
            $table->string('premium_in_paisa')->nullable()->after('new_premium');
            $table->string('new_premium_in_paisa')->nullable()->after('premium_in_paisa');
            $table->string('premium_in_aana')->nullable()->after('new_premium_in_paisa');
            $table->string('new_premium_in_aana')->nullable()->after('premium_in_aana');
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
