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
        Schema::table('temp_substitution_mutation', function (Blueprint $table) {
            $table->string('name_as_per_lease_conv_deed')->after('status_of_applicant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_substitution_mutation', function (Blueprint $table) {
            $table->dropColumn('name_as_per_lease_conv_deed');
        });
    }
};
