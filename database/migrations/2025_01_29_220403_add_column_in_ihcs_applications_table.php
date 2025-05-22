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
        Schema::table('ihcs_applications', function (Blueprint $table) {
            $table->string('individual_membership_remark')->nullable()->after('individual_membership_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ihcs_applications', function (Blueprint $table) {
            $table->dropColumn('individual_membership_remark');
        });
    }
};
