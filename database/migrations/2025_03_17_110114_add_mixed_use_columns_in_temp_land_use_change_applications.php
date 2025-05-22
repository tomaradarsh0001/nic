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
        Schema::table('temp_land_use_change_applications', function (Blueprint $table) {
            $table->boolean('mixed_use')->default(0)->after('property_subtype_change_to');
            $table->float('total_built_up_area', 14, 2)->nullable()->after('mixed_use');
            $table->float('commercial_area', 14, 2)->nullable()->after('total_built_up_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_land_use_change_applications', function (Blueprint $table) {
            $table->dropColumn('mixed_use');
            $table->dropColumn('total_built_up_area');
            $table->dropColumn('commercial_area');
        });
    }
};
