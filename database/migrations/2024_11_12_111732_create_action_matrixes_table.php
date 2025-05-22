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
        Schema::create('action_matrixes', function (Blueprint $table) {
            $table->id();
            $table->string('service_type');
            $table->string('action_one')->nullable();
            $table->integer('action_one_by_role')->nullable();
            $table->string('action_two')->nullable();
            $table->integer('action_two_by_role')->nullable();
            $table->string('action_to_be_taken')->nullable();
            $table->integer('sent_to_role')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_matrixes');
    }
};
