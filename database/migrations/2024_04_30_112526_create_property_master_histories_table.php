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
        Schema::create('property_master_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->boolean('is_multiple_ids')->nullable();
            $table->boolean('new_is_multiple_ids')->nullable();
            $table->string('file_no')->nullable();
            $table->string('new_file_no')->nullable();
            $table->string('unique_file_no')->nullable();
            $table->string('new_unique_file_no')->nullable();
            $table->string('lease_no')->nullable();
            $table->string('new_lease_no')->nullable();
            $table->string('plot_or_property_no')->nullable();
            $table->string('new_plot_or_property_no')->nullable();
            $table->string('land_type')->nullable();
            $table->string('new_land_type')->nullable();
            $table->string('old_colony_name')->nullable();
            $table->string('new_old_colony_name')->nullable();
            $table->string('new_colony_name')->nullable();
            $table->string('new_new_colony_name')->nullable();
            $table->string('block_no')->nullable();
            $table->string('new_block_no')->nullable();
            $table->string('property_type')->nullable();
            $table->string('new_property_type')->nullable();
            $table->string('property_sub_type')->nullable();
            $table->string('new_property_sub_type')->nullable();
            $table->string('status')->nullable();
            $table->string('new_status')->nullable();
            $table->string('main_property_id')->nullable();
            $table->string('new_main_property_id')->nullable();
            $table->string('section_code')->nullable();
            $table->string('new_section_code')->nullable();
            $table->boolean('is_transferred')->nullable();
            $table->boolean('new_is_transferred')->nullable();
            $table->string('transferred_to')->nullable();
            $table->string('new_transferred_to')->nullable()->nullable();
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
        Schema::dropIfExists('property_master_histories');
    }
};
