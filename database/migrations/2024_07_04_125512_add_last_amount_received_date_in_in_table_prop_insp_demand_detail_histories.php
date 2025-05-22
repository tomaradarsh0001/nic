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
        Schema::table('prop_insp_demand_detail_histories', function (Blueprint $table) {
            $table->date('last_amount_received_date')->after('new_last_amount_received')->nullable();
            $table->date('new_last_amount_received_date')->after('last_amount_received_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prop_insp_demand_detail_histories', function (Blueprint $table) {
            $table->dropColumn('last_amount_received_date');
            $table->dropColumn('new_last_amount_received_date');
        });
    }
};
