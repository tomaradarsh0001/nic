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
            Schema::rename('club_membership_dgcs', 'dgcs_applications'); // Rename 'club_membership_dgcs' to 'dgcs_applications'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dgcs_applications', function (Blueprint $table) {
            Schema::rename('dgcs_applications', 'club_membership_dgcs'); // Rename back if migration is rolled back
        });
    }
};
