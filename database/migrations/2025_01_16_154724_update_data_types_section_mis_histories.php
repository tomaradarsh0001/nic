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
        Schema::table('section_mis_histories', function (Blueprint $table) {
            $table->string('old_property_id')->change()->nullable(); // Change bigInt to string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_mis_histories', function (Blueprint $table) {
            $table->bigInteger('old_property_id')->change(); // Revert back to bigInt
        });
    }
};
