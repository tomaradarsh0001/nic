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
        Schema::create('property_transferred_lessee_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->integer('old_property_id')->nullable();
            $table->string('process_of_transfer')->nullable();
            $table->string('lessee_name')->nullable();
            $table->string('lessee_age')->nullable();
            $table->string('property_share')->nullable();
            $table->string('lessee_pan_no')->nullable();
            $table->string('lessee_aadhar_no')->nullable();
            $table->string('batch_transfer_id')->nullable();
            $table->string('previous_batch_transfer_id')->nullable();
            $table->string('linked_transfer_id')->nullable();
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
        Schema::dropIfExists('property_transferred_lessee_details');
    }
};
