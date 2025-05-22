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
        Schema::table('user_registrations', function (Blueprint $table) {
            // Make an existing column nullable
            $table->string('locality')->nullable()->change();
            // Add a new varchar column
            $table->string('locality_name', 255)->nullable()->after('locality'); // Default length is 255
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            // Revert the nullable change
            $table->string('locality')->nullable(false)->change();
            // Drop the new column
            $table->dropColumn('locality_name');
        });
    }
};
