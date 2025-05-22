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
            $table->dropForeign(['assigned_by']);
            $table->unsignedBigInteger('assigned_by')->nullable()->change();
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_movements', function (Blueprint $table) {
            $table->dropForeign(['assigned_by']);
            $table->unsignedBigInteger('assigned_by')->nullable(false)->change();
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
