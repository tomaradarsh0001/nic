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
        Schema::table('application_movements', function (Blueprint $table) {
            $table->string('assigned_by_role')->nullable()->after('assigned_by');
            $table->string('assigned_to_role')->nullable()->after('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_movements', function (Blueprint $table) {
            $table->dropColumn('assigned_by_role');
            $table->dropColumn('assigned_to_role');
        });
    }
};
