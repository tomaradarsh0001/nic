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
            $table->dropColumn('page_no_as_per_lease_conv_deed');
            $table->string('page_no_as_per_deed')->after('volume_no_as_per_lease_conv_deed');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_substitution_mutation', function (Blueprint $table) {
            $table->integer('page_no_as_per_lease_conv_deed')->after('volume_no_as_per_lease_conv_deed');
            $table->dropColumn('page_no_as_per_deed');
        });
    }
};
