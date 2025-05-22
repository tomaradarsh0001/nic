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
        Schema::table('club_membership_applications', function (Blueprint $table) {
            Schema::rename('club_memberships', 'club_membership_applications'); // Rename 'club_memberships' to 'club_membership_applications'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_membership_applications', function (Blueprint $table) {
            Schema::rename('club_membership_applications', 'club_memberships'); // Rename back if migration is rolled back
        });
    }
};
