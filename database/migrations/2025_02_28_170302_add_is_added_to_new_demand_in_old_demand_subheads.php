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
        Schema::table('old_demand_subheads', function (Blueprint $table) {
            $table->boolean('is_added_to_new_demand')->default(0)->after('PaymentType');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('old_demand_subheads', function (Blueprint $table) {
            $table->dropColumn('is_added_to_new_demand');
        });
    }
};
