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
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('flat_id')->nullable()->after('plot'); 
            $table->boolean('is_property_flat')->default(0)->after('flat_id');
            $table->foreign('flat_id')->references('id')->on('flats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->dropForeign(['flat_id']);
            $table->dropColumn('is_property_flat');
            $table->dropColumn('flat_id');
        });
    }
};
