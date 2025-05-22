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
            // Rename column before modifying its type
            $table->renameColumn('date_of_regular_membership', 'regular_membership_date_and_remark');
        });

        Schema::table('dgcs_applications', function (Blueprint $table) {
            // Change datatype after renaming
            $table->string('regular_membership_date_and_remark')->change();

            // Change datatype for 'is_post_under_central_staffing_scheme'
            $table->string('is_post_under_central_staffing_scheme')->change();

            // Drop the column after all necessary modifications
            $table->dropColumn('remark_of_regular_membership');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dgcs_applications', function (Blueprint $table) {
            // Restore deleted column first
            $table->string('remark_of_regular_membership')->nullable();
        });

        Schema::table('dgcs_applications', function (Blueprint $table) {
            // Rename column back to original
            $table->renameColumn('regular_membership_date_and_remark', 'date_of_regular_membership');
        });

        Schema::table('dgcs_applications', function (Blueprint $table) {
            // Revert datatype changes after renaming
            $table->dateTime('date_of_regular_membership')->change();
            $table->boolean('is_post_under_central_staffing_scheme')->change();
        });
    }
};
