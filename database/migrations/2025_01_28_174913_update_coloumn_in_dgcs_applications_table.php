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
        Schema::table('dgcs_applications', function (Blueprint $table) {
            
            $table->dropColumn('date_or_details_of_regular_membership');
            $table->dropColumn('dgc_tenure_period');
            $table->dateTime('date_of_regular_membership')->nullable()->after('is_post_under_central_staffing_scheme');
            $table->string('remark_of_regular_membership')->nullable()->after('date_of_regular_membership');
            $table->date('dgc_tenure_start_date')->nullable()->after('remark_of_regular_membership');
            $table->date('dgc_tenure_end_date')->nullable()->after('dgc_tenure_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dgcs_applications', function (Blueprint $table) {
            $table->string('date_or_details_of_regular_membership')->nullable()->after('is_post_under_central_staffing_scheme');
            $table->string('dgc_tenure_period')->nullable()->after('date_or_details_of_regular_membership');
            $table->dropColumn('date_of_regular_membership');
            $table->dropColumn('remark_of_regular_membership');
            $table->dropColumn('dgc_tenure_start_date');
            $table->dropColumn('dgc_tenure_end_date');
        });
    }
};
