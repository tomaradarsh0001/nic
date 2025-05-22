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
        Schema::create('user_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('old_property_id')->nullable();
            $table->integer('new_property_id')->nullable();
            $table->string('locality')->nullable();
            $table->string('block')->nullable();
            $table->string('plot')->nullable();
            $table->string('flat')->nullable();
            $table->string('known_as')->nullable();
            $table->string('section_code')->nullable();
            $table->tinyInteger('property_link_status')->default(0)->comment('1-approved, 2-reject');//1- approved, 2 reject
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_properties');
    }
};
