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
        Schema::table('appointment_details', function (Blueprint $table) {
            // Update the meeting_description column to be non-nullable
            $table->string('meeting_description')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            // Revert the meeting_description column to be nullable
            $table->string('meeting_description')->nullable()->change();
        });
    }
};
