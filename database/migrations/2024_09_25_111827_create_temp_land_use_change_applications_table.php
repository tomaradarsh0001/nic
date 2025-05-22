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
        Schema::create('temp_land_use_change_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('old_property_id');
            $table->string('new_property_id');
            $table->integer('property_master_id');
            $table->integer('splited_property_detail_id')->nullable();
            $table->integer('property_type_change_from');
            $table->integer('property_subtype_change_from');
            $table->integer('property_type_change_to');
            $table->integer('property_subtype_change_to');
            $table->smallInteger('applicant_status');
            $table->boolean('applicant_consent')->nullable();
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
        Schema::dropIfExists('temp_land_use_change_applications');
    }
};
