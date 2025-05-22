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
        Schema::table('club_membership_dgcs', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['membership_id']);
            // Rename the column
            $table->renameColumn('membership_id', 'membership_app_id');
        });

        Schema::table('club_membership_dgcs', function (Blueprint $table) {
            // Re-add the foreign key constraint for the renamed column
            $table->foreign('membership_app_id')->references('id')->on('club_memberships');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_membership_dgcs', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['membership_app_id']);
            // Rename the column back to its original name
            $table->renameColumn('membership_app_id', 'membership_id');
        });

        Schema::table('club_membership_dgcs', function (Blueprint $table) {
            // Re-add the original foreign key constraint
            $table->foreign('membership_id')->references('id')->on('club_memberships');
        });
    }
};
