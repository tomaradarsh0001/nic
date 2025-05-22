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
        Schema::table('property_transferred_lessee_details', function (Blueprint $table) {
            $table->date('transferDate')->after('process_of_transfer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_transferred_lessee_details', function (Blueprint $table) {
            $table->dropColumn('transferDate');
        });
    }
};
