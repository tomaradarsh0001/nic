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
        Schema::table('temp_deed_of_apartments', function (Blueprint $table) {
            $table->boolean('isFlatNotListed')->default(false)->after('flat_id');
            $table->string('undertaking')->nullable()->after('plot_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_deed_of_apartments', function (Blueprint $table) {
            $table->dropColumn('isFlatNotListed');
            $table->dropColumn('undertaking');
        });
    }
};
