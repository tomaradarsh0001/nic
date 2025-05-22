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
        Schema::table('temp_coapplicants', function (Blueprint $table) {
            $table->tinyInteger('index_no')->nullable()->after('model_name');
        });
        Schema::table('temp_documents', function (Blueprint $table) {
            $table->tinyInteger('index_no')->nullable()->after('model_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_coapplicants', function (Blueprint $table) {
            $table->dropColumn('index_no');
        });
        Schema::table('temp_documents', function (Blueprint $table) {
            $table->dropColumn('index_no');
        });
    }
};
