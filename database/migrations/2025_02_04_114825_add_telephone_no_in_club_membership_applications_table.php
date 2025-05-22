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
            $table->string('telephone_no')->after('office_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_membership_applications', function (Blueprint $table) {
            $table->dropColumn('telephone_no');
        });
    }
};
