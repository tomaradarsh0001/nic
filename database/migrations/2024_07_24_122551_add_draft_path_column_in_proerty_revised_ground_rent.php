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
            $table->string('draft_file_path')->nullable()->after('calculated_on_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_revivised_ground_rent', function (Blueprint $table) {
            $table->dropColumn('draft_file_path');
        });
    }
};
