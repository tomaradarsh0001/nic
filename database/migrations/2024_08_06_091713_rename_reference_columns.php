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
        Schema::table('demands', function (Blueprint $table) {
            $table->renameColumn('forwarded_from_id', 'forward_reference_id');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('reference_no', 'reference_id');
            $table->renameColumn('status', 'reference_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->renameColumn('forward_reference_id', 'forwarded_from_id');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('reference_id', 'reference_no',);
            $table->renameColumn('reference_status', 'status');
        });
    }
};
