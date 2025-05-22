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
        Schema::create('property_masters', function (Blueprint $table) {
            $table->id();
            $table->string('old_propert_id')->nullable();
            $table->string('unique_propert_id')->nullable();
            $table->boolean('is_multiple_ids')->default(false);
            $table->string('file_no')->nullable();
            $table->string('unique_file_no')->nullable();
            $table->string('lease_no')->nullable();
            $table->string('plot_or_property_no')->nullable();
            $table->string('land_type')->nullable();
            $table->string('old_colony_name')->nullable();
            $table->string('new_colony_name')->nullable();
            $table->string('block_no')->nullable();
            $table->string('property_type')->nullable();
            $table->string('property_sub_type')->nullable();
            $table->enum('status', ['LH', 'FH','Other']);
            $table->string('main_property_id')->nullable();
            $table->string('section_code')->nullable();
            $table->boolean('is_transferred')->default(false);
            $table->string('transferred_to')->nullable();
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
        Schema::dropIfExists('property_masters');
    }
};
