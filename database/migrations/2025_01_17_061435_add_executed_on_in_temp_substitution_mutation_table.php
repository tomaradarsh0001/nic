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
            $table->date('executed_on')->after('father_name_as_per_lease_conv_deed');
            $table->string('father_name_as_per_lease_conv_deed')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_substitution_mutation', function (Blueprint $table) {
            $table->dropColumn('executed_on');
            $table->string('father_name_as_per_lease_conv_deed')->nullable(false)->change();
        });
    }
};
