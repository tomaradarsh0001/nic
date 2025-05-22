<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('club_membership_applications', function (Blueprint $table) {
            $table->date('date_of_joining_central_deputation')->nullable()->default(null)->change();
            $table->date('expected_date_of_tenure_completion')->nullable()->default(null)->change();
            $table->text('present_previous_membership_of_other_clubs')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_membership_applications', function (Blueprint $table) {
            $table->date('date_of_joining_central_deputation')->nullable(false)->change();
            $table->date('expected_date_of_tenure_completion')->nullable(false)->change();
            $table->text('present_previous_membership_of_other_clubs')->nullable(false)->change();
        });
    }
};
