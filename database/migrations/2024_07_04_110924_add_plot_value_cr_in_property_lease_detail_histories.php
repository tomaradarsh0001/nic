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
        Schema::table('property_lease_detail_histories', function (Blueprint $table) {
            $table->string('plot_value_cr')->nullable()->after('new_plot_value');
            $table->string('new_plot_value_cr')->nullable()->after('plot_value_cr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_lease_detail_histories', function (Blueprint $table) {
            $table->dropColumn('plot_value_cr');
            $table->dropColumn('new_plot_value_cr');
        });
    }
};
