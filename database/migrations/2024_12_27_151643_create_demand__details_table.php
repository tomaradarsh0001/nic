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
        Schema::dropIfExists('demand_details');
        Schema::create('demand_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('demand_id');
            $table->bigInteger('property_master_id')->nullable();
            $table->bigInteger('splited_property_detail_id')->nullable();
            $table->bigInteger('flat_id')->nullable();
            $table->integer('subhead_id');
            $table->decimal('total', 12, 2)->nullable();
            $table->decimal('net_total', 12, 2)->nullable();
            $table->decimal('paid_amount', 12, 2)->nullable();
            $table->decimal('balance_amount', 12, 2)->nullable();
            $table->decimal('carried_amount', 12, 2)->nullable();
            $table->date('duration_from')->nullable();
            $table->date('duration_to')->nullable();
            $table->string('fy', 10)->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('demand_details');
    }
};
