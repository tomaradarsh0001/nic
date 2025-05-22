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
            $table->integer('payment_mode')->nullable()->after('amount');
            $table->string('unique_payment_id', 20)->after('payment_mode');
            $table->text('request')->nullable()->after('unique_payment_id');
            $table->text('response')->nullable()->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_mode');
            $table->dropColumn('unique_payment_id');
            $table->dropColumn('request');
            $table->dropColumn('response');
        });
    }
};
