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
        Schema::create('splited_property_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->string('parent_prop_id')->nullable();
            $table->string('child_prop_id')->nullable();
            $table->string('plot_flat_no')->nullable();
            $table->string('original_area')->nullable();
            $table->string('current_area')->nullable();
            $table->string('presently_known_as')->nullable();
            $table->integer('old_property_id')->nullable();
            $table->string('property_status')->nullable();
            $table->boolean('is_active')->default(true)->nullable();

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
        Schema::dropIfExists('splited_property_details');
    }
};
