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
        Schema::table('newly_added_properties', function (Blueprint $table) {
            $table->string('other_doc')->after('substitution_mutation_letter_doc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newly_added_properties', function (Blueprint $table) {
            $table->dropColumn('other_doc');
        });
    }
};
