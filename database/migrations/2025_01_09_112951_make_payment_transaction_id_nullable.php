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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->change();
            $table->decimal('amount', total: 14, places: 2)->default(0.00)->change();
        });
        Schema::table('payment_details', function (Blueprint $table) {
            $table->string('application_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('transaction_id')->nullable(false)->change();
            $table->decimal('amount', total: 12, places: 2)->default(0.00)->change();
        });
        Schema::table('payment_details', function (Blueprint $table) {
            $table->string('application_no')->nullable(false)->change();
        });
    }
};
