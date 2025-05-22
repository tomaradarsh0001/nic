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
        Schema::table('applicant_user_details', function (Blueprint $table) {
            $table->date('dob')->after('gender')->nullable();
            $table->integer('age')->after('dob')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_user_details', function (Blueprint $table) {
            $table->dropColumn('dob');
            $table->dropColumn('age');
        });
    }
};
