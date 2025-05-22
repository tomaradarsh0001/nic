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
        Schema::table('property_master_histories', function (Blueprint $table) {
            $table->string('additional_remark')->after('new_transferred_to')->nullable();
            $table->string('new_additional_remark')->after('additional_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_master_histories', function (Blueprint $table) {
            $table->dropColumn('additional_remark');
            $table->dropColumn('new_additional_remark');
        });
    }
};
