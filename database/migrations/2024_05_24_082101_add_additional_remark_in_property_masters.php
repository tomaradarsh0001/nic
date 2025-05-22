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
        Schema::table('property_masters', function (Blueprint $table) {
            $table->string('additional_remark')->nullable()->after('transferred_to');
            $table->enum('alert_flag', ['0', '1'])->default('0')->after('additional_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_masters', function (Blueprint $table) {
            $table->dropColumn('additional_remark');
            $table->dropColumn('alert_flag');
        });
    }
};
