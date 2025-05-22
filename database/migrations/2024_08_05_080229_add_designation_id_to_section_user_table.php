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
        Schema::table('section_user', function (Blueprint $table) {
             // Add the new column after the 'password' column
             $table->unsignedBigInteger('designation_id')->nullable()->after('section_id');
             $table->foreign('designation_id')->references('id')->on('designations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_user', function (Blueprint $table) {
            // Drop the foreign key and column if rolling back
            $table->dropForeign(['designation_id']);
            $table->dropColumn('designation_id');
        });
    }
};
