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
            $table->string('second_name')->after('so_do_spouse')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_user_details', function (Blueprint $table) {
            $table->dropColumn('second_name');
        });
    }
};
