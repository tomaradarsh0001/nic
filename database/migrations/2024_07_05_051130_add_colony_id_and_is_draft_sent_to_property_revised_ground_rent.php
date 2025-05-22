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
        Schema::table('property_revivised_ground_rent', function (Blueprint $table) {
            $table->integer('colony_id')->nullable()->after('splited_property_detail_id');
            $table->boolean('is_draft_sent')->after('calculated_on_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_revivised_ground_rent', function (Blueprint $table) {
            $table->dropColumn('colony_id');
            $table->dropColumn('is_draft_sent');
        });
    }
};
