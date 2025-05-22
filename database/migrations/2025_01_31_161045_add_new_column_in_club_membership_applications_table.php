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
            $table->string('other_category')->after('category')->nullable();
            $table->string('other_designation_equivalent_to')->after('designation_equivalent_to')->nullable();
            $table->string('department')->after('other_designation_equivalent_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_membership_applications', function (Blueprint $table) {
            $table->dropColumn('other_category');
            $table->dropColumn('other_designation_equivalent_to');
            $table->dropColumn('department');
        });
    }
};
