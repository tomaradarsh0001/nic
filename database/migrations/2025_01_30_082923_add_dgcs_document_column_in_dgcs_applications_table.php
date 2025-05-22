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
            $table->string('dgcs_doc')->nullable()->after('ihc_nomination_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dgcs_applications', function (Blueprint $table) {
            $table->dropColumn('dgcs_doc');
        });
    }
};
