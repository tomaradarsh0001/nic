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
        Schema::dropIfExists('demands');
        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->bigInteger('property_master_id')->nullable();
            $table->bigInteger('splited_property_detail_id')->nullable();
            $table->bigInteger('flat_id')->nullable();
            $table->string('old_property_id')->nullable();
            $table->string('app_no')->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->decimal('net_total', 12, 2)->nullable();
            $table->decimal('paid_amount', 12, 2)->nullable();
            $table->decimal('balance_amount', 12, 2)->nullable();
            $table->decimal('carried_amount', 12, 2)->nullable();
            $table->string('fy_prev_demand', 10)->nullable();
            $table->string('current_fy', 10)->nullable();
            $table->integer('status');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demands');
    }
};
