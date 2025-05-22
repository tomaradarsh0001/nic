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
        Schema::table('user_properties', function (Blueprint $table) {
            $table->unsignedBigInteger('flat_id')->nullable()->after('new_property_id'); // Adjust 'after' position if needed
            $table->foreign('flat_id')->references('id')->on('flats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_properties', function (Blueprint $table) {
            $table->dropForeign(['flat_id']);
            $table->dropColumn('flat_id');
        });
    }
};
