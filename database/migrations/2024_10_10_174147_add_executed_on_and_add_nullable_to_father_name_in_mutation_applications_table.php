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
        Schema::table('mutation_applications', function (Blueprint $table) {
            $table->string('father_name_as_per_lease_conv_deed')->nullable()->change();
            $table->date('executed_on')->after('father_name_as_per_lease_conv_deed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mutation_applications', function (Blueprint $table) {
            $table->string('father_name_as_per_lease_conv_deed')->nullable(false);
            $table->dropColumn('executed_on');
        });
    }
};
