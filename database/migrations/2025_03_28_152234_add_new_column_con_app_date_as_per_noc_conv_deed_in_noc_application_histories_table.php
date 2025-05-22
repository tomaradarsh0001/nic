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
        Schema::table('noc_application_histories', function (Blueprint $table) {
            $table->date('con_app_date_as_per_noc_conv_deed')->after('new_reg_date_as_per_noc_conv_deed')->nullable();
            $table->date('new_con_app_date_as_per_noc_conv_deed')->after('con_app_date_as_per_noc_conv_deed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noc_application_histories', function (Blueprint $table) {
            $table->dropColumn('con_app_date_as_per_noc_conv_deed');
            $table->dropColumn('new_con_app_date_as_per_noc_conv_deed');
        });
    }
};