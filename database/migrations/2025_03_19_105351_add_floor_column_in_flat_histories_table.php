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
        Schema::table('flat_histories', function (Blueprint $table) {
            $table->string('floor')->nullable()->after('new_unique_file_no');
            $table->string('new_floor')->nullable()->after('floor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flat_histories', function (Blueprint $table) {
            $table->dropColumn('floor');
            $table->dropColumn('new_floor');
        });
    }
};
