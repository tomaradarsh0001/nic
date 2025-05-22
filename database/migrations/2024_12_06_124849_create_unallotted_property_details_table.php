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
        Schema::create('unallotted_property_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->integer('old_property_id');
            $table->decimal('plot_area')->nullable();
            $table->integer('unit')->nullable();
            $table->decimal('plot_area_in_sqm')->nullable();
            $table->decimal('plot_value', 18, 2)->nullable();
            $table->decimal('plot_value_cr', 18, 2)->nullable();
            $table->boolean('is_litigation')->default(false);
            $table->boolean('is_encrached')->default(false);
            $table->boolean('is_vaccant')->default(false);
            $table->boolean('is_transferred')->default(false);
            $table->integer('transferred_to')->nullable();
            $table->date('date_of_transfer')->nullable();
            $table->text('purpose')->nullable();
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
        Schema::dropIfExists('unallotted_property_details');
    }
};
