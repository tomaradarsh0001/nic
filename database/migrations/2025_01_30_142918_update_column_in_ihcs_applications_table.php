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
            // Rename column first before modifying its type
            $table->renameColumn('individual_membership_date', 'individual_membership_date_and_remark');
        });

        Schema::table('ihcs_applications', function (Blueprint $table) {
            // Change datatype after renaming
            $table->string('individual_membership_date_and_remark')->change();
            
            // Drop the column after all necessary modifications
            $table->dropColumn('individual_membership_remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ihcs_applications', function (Blueprint $table) {
            // Restore deleted column first
            $table->string('individual_membership_remark')->nullable();
        });

        Schema::table('ihcs_applications', function (Blueprint $table) {
            // Rename column back to original
            $table->renameColumn('individual_membership_date_and_remark', 'individual_membership_date');
        });

        Schema::table('ihcs_applications', function (Blueprint $table) {
            // Change datatype back after renaming
            $table->date('individual_membership_date')->change();
        });
    }
};
