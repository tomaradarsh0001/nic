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
        Schema::table('newly_added_properties', function (Blueprint $table) {
            $table->string('generated_pid')->nullable()->after('applicant_number')->comment('PropertyId created by IT Cell For Manual Added Property'); // Change bigInt to string
            $table->string('locality_name', 255)->nullable()->after('locality'); // Default length is 255
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newly_added_properties', function (Blueprint $table) {
            $table->dropColumn('generated_pid');
            $table->dropColumn('locality_name');
        });
    }
};
