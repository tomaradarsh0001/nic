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
            $table->integer('service_type')->nullable()->after('splited_old_property_id');
            $table->decimal('paid_amount', total: 12, places: 2)->nullable()->after('amount');
            $table->renameColumn('amount', 'total_amount');
        });
        Schema::table('demand_details', function (Blueprint $table) {
            $table->integer('subhead_type')->nullable()->after('splited_old_property_id');
            $table->decimal('paid_amount', total: 12, places: 2)->nullable()->after('amount');
            $table->renameColumn('amount', 'total_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demands', function (Blueprint $table) {
            Schema::table('demands', function (Blueprint $table) {
                $table->dropColumn('service_type');
                $table->dropColumn('paid_amount');
                $table->renameColumn('total_amount', 'amount');
            });
            Schema::table('demand_details', function (Blueprint $table) {
                $table->dropColumn('subhead_type');
                $table->dropColumn('paid_amount');
                $table->renameColumn('total_amount', 'amount');
            });
        });
    }
};
