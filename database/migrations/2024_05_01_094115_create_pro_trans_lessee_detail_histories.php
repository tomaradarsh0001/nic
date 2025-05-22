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
        Schema::create('pro_trans_lessee_detail_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->string('lessee_id');
            $table->string('process_of_transfer')->nullable();
            $table->string('new_process_of_transfer')->nullable();
            $table->string('transferDate')->nullable();
            $table->string('new_transferDate')->nullable();
            $table->string('lessee_name')->nullable();
            $table->string('new_lessee_name')->nullable();
            $table->string('lessee_age')->nullable();
            $table->string('new_lessee_age')->nullable();
            $table->string('property_share')->nullable();
            $table->string('new_property_share')->nullable();
            $table->string('lessee_pan_no')->nullable();
            $table->string('new_lessee_pan_no')->nullable();
            $table->string('lessee_aadhar_no')->nullable();
            $table->string('new_lessee_aadhar_no')->nullable();
            $table->string('batch_transfer_id')->nullable();
            $table->string('new_batch_transfer_id')->nullable();
            $table->string('previous_batch_transfer_id')->nullable();
            $table->string('new_previous_batch_transfer_id')->nullable();
            $table->string('linked_transfer_id')->nullable();
            $table->string('new_linked_transfer_id')->nullable();
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
        Schema::dropIfExists('pro_trans_lessee_detail_histories');
    }
};
