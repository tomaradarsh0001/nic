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
        Schema::table('dgcs_applications_histories', function (Blueprint $table) {
            $table->renameColumn('handicap_certification_date', 'handicap_certification');
            $table->renameColumn('new_handicap_certification_date', 'new_handicap_certification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dgcs_applications_histories', function (Blueprint $table) {
            // Revert the column name
            $table->renameColumn('handicap_certification', 'handicap_certification_date');
            $table->renameColumn('new_handicap_certification', 'new_handicap_certification_date');
        });
    }
};
