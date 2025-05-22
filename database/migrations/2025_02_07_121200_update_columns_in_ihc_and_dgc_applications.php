<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify ihc_applications table
        Schema::table('ihcs_applications', function (Blueprint $table) {
            $table->date('dgc_tenure_start_date')->nullable()->change();
            $table->date('dgc_tenure_end_date')->nullable()->change();
        });

        // Modify dgc_applications table
        Schema::table('dgcs_applications', function (Blueprint $table) {
            $table->date('dgc_tenure_start_date')->nullable()->change();
            $table->date('dgc_tenure_end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert ihc_applications table changes
        Schema::table('ihcs_applications', function (Blueprint $table) {
            $table->dateTime('dgc_tenure_start_date')->nullable()->change();
            $table->dateTime('dgc_tenure_end_date')->nullable()->change();
        });

        // Revert dgc_applications table changes
        Schema::table('dgcs_applications', function (Blueprint $table) {
            $table->dateTime('dgc_tenure_start_date')->nullable()->change();
            $table->dateTime('dgc_tenure_end_date')->nullable()->change();
        });
    }
};
