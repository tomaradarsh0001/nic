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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('model')->nullable()->after('demand_id');
            $table->bigInteger('model_id')->nullable()->after('model');
            $table->dropColumn('demand_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('model')->nullable()->after('demand_id');
            $table->dropColumn('model_id');
            $table->foreignId('demand_id')->after(' id');
        });
    }
};
