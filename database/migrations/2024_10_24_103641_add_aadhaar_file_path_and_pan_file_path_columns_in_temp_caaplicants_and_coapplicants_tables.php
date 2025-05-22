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
            $table->string('aadhaar_file_path')->nullable()->after('co_applicant_aadhar');
            $table->string('pan_file_path')->nullable()->after('co_applicant_pan');
            // $table->string('image_path')->after('pan_file_path')->change();
        });
        Schema::table('coapplicants', function (Blueprint $table) {
            $table->string('aadhaar_file_path')->nullable()->after('co_applicant_aadhar');
            $table->string('pan_file_path')->nullable()->after('co_applicant_pan');
            // $table->string('image_path')->nullable()->after('pan_file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_coapplicants', function (Blueprint $table) {
            $table->dropColumn('aadhaar_file_path');
            $table->dropColumn('pan_file_path');
        });
        Schema::table('coapplicants', function (Blueprint $table) {
            $table->dropColumn('aadhaar_file_path');
            $table->dropColumn('pan_file_path');
            $table->dropColumn('image_path');
        });
    }
};
