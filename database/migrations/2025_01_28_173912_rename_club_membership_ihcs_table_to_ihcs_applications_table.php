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
            Schema::rename('club_membership_ihcs', 'ihcs_applications'); // Rename 'club_membership_ihcs' to 'ihcs_applications'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ihcs_applications', function (Blueprint $table) {
            Schema::rename('ihcs_applications', 'club_membership_ihcs'); // Rename back if migration is rolled back
        });
    }
};
