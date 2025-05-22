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
        Schema::table('property_misc_details', function (Blueprint $table) {
            $table->decimal('supplementary_area', 10)->after('supplimentry_lease_deed_executed_date')->nullable();
            $table->string('supplementary_area_unit', 50)->after('supplementary_area')->nullable();
            $table->decimal('supplementary_area_in_sqm', 10)->after('supplementary_area_unit')->nullable();
            $table->decimal('supplementary_premium', 10)->after('supplementary_area_in_sqm')->nullable();
            $table->decimal('supplementary_premium_in_paisa', 10)->after('supplementary_premium')->nullable();
            $table->decimal('supplementary_premium_in_aana', 10)->after('supplementary_premium_in_paisa')->nullable();
            $table->decimal('supplementary_total_premium', 10)->after('supplementary_premium_in_aana')->nullable();
            $table->decimal('supplementary_gr_in_re_rs', 10)->after('supplementary_total_premium')->nullable();
            $table->decimal('supplementary_gr_in_paisa', 10)->after('supplementary_gr_in_re_rs')->nullable();
            $table->decimal('supplementary_gr_in_aana', 10)->after('supplementary_gr_in_paisa')->nullable();
            $table->decimal('supplementary_total_gr', 10)->after('supplementary_gr_in_aana')->nullable();
            $table->string('supplementary_remark', 255)->after('supplementary_total_gr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_misc_details', function (Blueprint $table) {
            $table->dropColumn('supplementary_area');
            $table->dropColumn('supplementary_area_unit');
            $table->dropColumn('supplementary_area_in_sqm');
            $table->dropColumn('supplementary_premium');
            $table->dropColumn('supplementary_premium_in_paisa');
            $table->dropColumn('supplementary_premium_in_aana');
            $table->dropColumn('supplementary_total_premium');
            $table->dropColumn('supplementary_gr_in_re_rs');
            $table->dropColumn('supplementary_gr_in_paisa');
            $table->dropColumn('supplementary_gr_in_aana');
            $table->dropColumn('supplementary_total_gr');
            $table->dropColumn('supplementary_remark');
        });
    }
};
