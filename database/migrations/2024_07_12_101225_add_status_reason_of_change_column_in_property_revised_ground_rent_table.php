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
            $table->enum('status', ['draft', 'final', 'withdrawn'])->nullable()->after('is_draft_sent');
            $table->boolean('reason_for_change')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_revivised_ground_rent', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('reason_for_change');
        });
    }
};
