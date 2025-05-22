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
        Schema::table('temp_deed_of_apartments', function (Blueprint $table) {
            $table->integer('property_status')->nullable()->after('splited_property_detail_id');
            $table->integer('status_of_applicant')->nullable()->after('property_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_deed_of_apartments', function (Blueprint $table) {
            $table->dropColumn('property_status');
            $table->dropColumn('status_of_applicant');
        });
    }
};
