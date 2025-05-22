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
        if (Schema::hasColumn('demands', 'is_manual')) {
            Schema::table('demands', function (Blueprint $table) {
                $table->dropColumn('is_manual');
            });
        }
        Schema::table('demand_details', function (Blueprint $table) {
            $table->integer('formula_id')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demand_details', function (Blueprint $table) {
            $table->dropColumn('formula_id');
        });
    }
};
