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
        Schema::dropIfExists('payments');
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->nullable();
            $table->string('application_no')->nullable();
            $table->string('model')->nullable();
            $table->bigInteger('model_id')->nullable();
            $table->bigInteger('demand_id')->nullable();
            $table->foreignId('property_master_id');
            $table->foreignId('splited_property_detail_id')->nullable();
            $table->integer('master_old_property_id');
            $table->integer('splited_old_property_id')->nullable();
            $table->decimal('amount', total: 12, places: 2)->default(0.00);
            $table->string('transaction_id');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
