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
        Schema::table('demands', function (Blueprint $table) {
            $table->double('total', 14, 2)->change();
            $table->double('net_total', 14, 2)->change();
            $table->double('paid_amount', 14, 2)->change();
            $table->double('balance_amount', 14, 2)->change();
            $table->double('carried_amount', 14, 2)->change();
        });
        Schema::table('demand_details', function (Blueprint $table) {
            $table->double('total', 14, 2)->change();
            $table->double('net_total', 14, 2)->change();
            $table->double('paid_amount', 14, 2)->change();
            $table->double('balance_amount', 14, 2)->change();
            $table->double('carried_amount', 14, 2)->change();
        });
        Schema::table('carried_demand_details', function (Blueprint $table) {
            $table->double('carried_amount', 14, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->double('total', 12, 2)->change();
            $table->double('net_total', 12, 2)->change();
            $table->double('paid_amount', 12, 2)->change();
            $table->double('balance_amount', 12, 2)->change();
            $table->double('carried_amount', 12, 2)->change();
        });
        Schema::table('demand_details', function (Blueprint $table) {
            $table->double('total', 12, 2)->change();
            $table->double('net_total', 12, 2)->change();
            $table->double('paid_amount', 12, 2)->change();
            $table->double('balance_amount', 12, 2)->change();
            $table->double('carried_amount', 12, 2)->change();
        });
        Schema::table('carried_demand_details', function (Blueprint $table) {
            $table->double('carried_amount', 14, 2)->change();
        });
    }
};
