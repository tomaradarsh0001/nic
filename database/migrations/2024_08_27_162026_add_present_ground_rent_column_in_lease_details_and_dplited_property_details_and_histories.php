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
        Schema::table('property_lease_details', function (Blueprint $table) {
            $table->decimal('present_ground_rent', total: 12, places: 2)->nullable()->after('first_rgr_due_on');
        });
        Schema::table('property_lease_detail_histories', function (Blueprint $table) {
            $table->decimal('present_ground_rent', total: 12, places: 2)->nullable()->after('new_first_rgr_due_on');
            $table->decimal('new_present_ground_rent', total: 12, places: 2)->nullable()->after('present_ground_rent');
        });


        Schema::table('splited_property_details', function (Blueprint $table) {
            $table->decimal('present_ground_rent', total: 12, places: 2)->nullable()->after('plot_value_cr');
        });
        Schema::table('splited_property_detail_histories', function (Blueprint $table) {
            $table->decimal('present_ground_rent', total: 12, places: 2)->nullable()->after('new_plot_value_cr');
            $table->decimal('new_present_ground_rent', total: 12, places: 2)->nullable()->after('present_ground_rent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_lease_details', function (Blueprint $table) {
            $table->dropColumn('present_ground_rent');
        });
        Schema::table('property_lease_detail_histories', function (Blueprint $table) {
            $table->dropColumn('present_ground_rent');
            $table->dropColumn('new_present_ground_rent');
        });


        Schema::table('splited_property_details', function (Blueprint $table) {
            $table->dropColumn('present_ground_rent');
        });
        Schema::table('splited_property_detail_histories', function (Blueprint $table) {
            $table->dropColumn('present_ground_rent');
            $table->dropColumn('new_present_ground_rent');
        });
    }
};
