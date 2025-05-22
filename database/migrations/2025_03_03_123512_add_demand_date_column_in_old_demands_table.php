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
        /* Schema::table('old_demands', function (Blueprint $table) {
            $table->date('demand_date')->nullable()->after('outstanding')->chnage();
        }); */
        Schema::table('old_demand_subheads', function (Blueprint $table) {
            $table->string('PaymentType', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('old_demands', function (Blueprint $table) {
            $table->dropColumn('demand_date');
        });
        Schema::table('old_demand_subheads', function (Blueprint $table) {
            $table->string('PaymentType', 5)->chnane();
        });
    }
};
