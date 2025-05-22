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
        Schema::create('land_use_change_application_histories', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->integer('property_type_change_to')->nullable();
            $table->integer('new_property_type_change_to')->nullable();
            $table->integer('property_subtype_change_to')->nullable();
            $table->integer('new_property_subtype_change_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_use_change_application_histories');
    }
};
