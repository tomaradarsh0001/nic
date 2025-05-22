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
        Schema::create('splited_property_detail_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('splited_property_detail_id');
            $table->string('plot_flat_no')->nullable();
            $table->string('new_plot_flat_no')->nullable();
            $table->string('original_area')->nullable();
            $table->string('new_original_area')->nullable();
            $table->string('current_area')->nullable();
            $table->string('new_current_area')->nullable();
            $table->string('presently_known_as')->nullable();
            $table->string('new_presently_known_as')->nullable();
            $table->string('old_property_id')->nullable();
            $table->string('new_old_property_id')->nullable();
            $table->string('property_status')->nullable();
            $table->string('new_property_status')->nullable();
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
        Schema::dropIfExists('splited_property_detail_histories');
    }
};
