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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id');
            $table->foreignId('head_id');
            $table->foreignId('property_master_id');
            $table->foreignId('splited_property_detail_id')->nullable();
            $table->integer('master_old_property_id');
            $table->integer('splited_old_property_id')->nullable();
            $table->decimal('payment_amount', 10, 2, true)->nullable();
            $table->boolean('transaction_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
