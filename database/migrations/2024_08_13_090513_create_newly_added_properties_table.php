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
        Schema::create('newly_added_properties', function (Blueprint $table) {
            $table->id();
            $table->integer('old_property_id')->nullable();
            $table->integer('suggested_property_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('locality')->nullable();
            $table->string('block')->nullable();
            $table->string('plot')->nullable();
            $table->string('flat')->nullable();
            $table->string('known_as')->nullable();
            $table->integer('land_use_type')->nullable();
            $table->integer('land_use_sub_type')->nullable();
            $table->integer('status');
            $table->integer('section_id')->nullable();
            $table->string('sale_deed_doc')->nullable();
            $table->string('builder_buyer_agreement_doc')->nullable();
            $table->string('lease_deed_doc')->nullable();
            $table->string('substitution_mutation_letter_doc')->nullable();
            $table->string('owner_lessee_doc')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newly_added_properties');
    }
};
