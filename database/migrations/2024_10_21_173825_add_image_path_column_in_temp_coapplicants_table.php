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
            $table->string('image_path')->after('co_applicant_mobile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_coapplicants', function (Blueprint $table) {
            $table->dropColumn(' image_path');
        });
    }
};
