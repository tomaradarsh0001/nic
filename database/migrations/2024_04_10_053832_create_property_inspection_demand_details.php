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
        Schema::create('property_inspection_demand_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->integer('old_property_id')->nullable();
            $table->date('last_inspection_ir_date')->nullable();
            $table->date('last_demand_letter_date')->nullable();
            $table->integer('last_demand_id')->nullable();
            $table->string('last_demand_amount')->nullable();
            $table->string('last_amount_received')->nullable();
            $table->string('total_dues')->nullable();
            $table->boolean('is_active')->default(true);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_inspection_demand_details');
    }
};
