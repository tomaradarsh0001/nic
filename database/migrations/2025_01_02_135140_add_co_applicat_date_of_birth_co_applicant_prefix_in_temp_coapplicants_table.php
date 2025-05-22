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
        Schema::table('temp_coapplicants', function (Blueprint $table) {
            $table->string('prefix')->nullable()->after('co_applicant_age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_coapplicants', function (Blueprint $table) {
            $table->dropColumn('prefix');
        });
    }
};
