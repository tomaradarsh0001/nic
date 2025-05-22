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
            $table->integer('land_use_type')->nullable()->after('known_as');
            $table->integer('land_use_sub_type')->nullable()->after('land_use_type');
            $table->integer('section_id')->nullable()->after('land_use_sub_type');
            $table->string('remarks')->nullable()->after('consent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->dropColumn(['land_use_type', 'land_use_sub_type', 'section_id', 'remarks']);
        });
    }
};
