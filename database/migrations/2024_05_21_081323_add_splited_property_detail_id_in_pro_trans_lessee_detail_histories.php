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
        Schema::table('pro_trans_lessee_detail_histories', function (Blueprint $table) {
            $table->integer('splited_property_detail_id')->after('property_master_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pro_trans_lessee_detail_histories', function (Blueprint $table) {
            $table->dropColumn('splited_property_detail_id');
        });
    }
};
