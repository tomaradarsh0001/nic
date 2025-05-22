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
            $table->dropColumn('dgc_tenure_period');
            $table->date('dgc_tenure_start_date')->nullable()->after('individual_membership_date');
            $table->date('dgc_tenure_end_date')->nullable()->after('dgc_tenure_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ihcs_applications', function (Blueprint $table) {
            $table->string('dgc_tenure_period')->nullable()->after('individual_membership_date');
            $table->dropColumn('dgc_tenure_start_date');
            $table->dropColumn('dgc_tenure_end_date');
        });
    }
};
