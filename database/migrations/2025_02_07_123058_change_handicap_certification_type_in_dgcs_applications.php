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
        Schema::table('dgcs_applications', function (Blueprint $table) {
            // Change column type to string
            $table->string('handicap_certification', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dgcs_applications', function (Blueprint $table) {
            // Revert the column type back to date
            $table->date('handicap_certification')->nullable()->change();
        });
    }
};
