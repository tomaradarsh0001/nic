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
        Schema::table('app_latest_actions', function (Blueprint $table) {
            $table->integer('prev_role_id')->nullable()->after('prev_action_by');
            $table->integer('latest_role_id')->nullable()->after('latest_action_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_latest_actions', function (Blueprint $table) {
            $table->dropColumn('prev_role_id');
            $table->dropColumn('latest_role_id');
        });
    }
};
