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
        Schema::create('prop_insp_demand_detail_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->date('last_inspection_ir_date')->nullable();
            $table->date('new_last_inspection_ir_date')->nullable();
            $table->date('last_demand_letter_date')->nullable();
            $table->date('new_last_demand_letter_date')->nullable();
            $table->integer('last_demand_id')->nullable();
            $table->integer('new_last_demand_id')->nullable();
            $table->string('last_demand_amount')->nullable();
            $table->string('new_last_demand_amount')->nullable();
            $table->string('last_amount_received')->nullable();
            $table->string('new_last_amount_received')->nullable();
            $table->string('total_dues')->nullable();
            $table->string('new_total_dues')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('new_is_active')->nullable();

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prop_insp_demand_detail_histories');
    }
};
