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
        Schema::create('deed_of_apartment_application_histories', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->string('building_name')->nullable();
            $table->string('new_building_name')->nullable();
            $table->string('original_buyer_name')->nullable();
            $table->string('new_original_buyer_name')->nullable();
            $table->string('present_occupant_name')->nullable();
            $table->string('new_present_occupant_name')->nullable();
            $table->string('purchased_from')->nullable();
            $table->string('new_purchased_from')->nullable();
            $table->date('purchased_date')->nullable();
            $table->date('new_purchased_date')->nullable();
            $table->string('flat_area')->nullable();
            $table->string('new_flat_area')->nullable();
            $table->string('plot_area')->nullable();
            $table->string('new_plot_area')->nullable();
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
        Schema::dropIfExists('deed_of_apartment_application_histories');
    }
};
