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
        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // Ensure the column exists and set its default value to null
            $table->string('recording')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // To revert the change, set the default back to the original setting or remove default
            // Check the original schema definition if the default needs to be specific
            $table->string('recording')->nullable(false)->default(null)->change(); // Modify as needed
        });
    }
};
