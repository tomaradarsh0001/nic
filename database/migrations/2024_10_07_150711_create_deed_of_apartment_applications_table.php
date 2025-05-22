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
        Schema::create('deed_of_apartment_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->integer('old_property_id');
            $table->string('new_property_id');
            $table->integer('property_master_id');
            $table->integer('splited_property_detail_id')->nullable();
            $table->integer('property_status')->nullable();
            $table->integer('status_of_applicant')->nullable();
            $table->string('service_type')->nullable()->comment('id from items table for item_code DOA');
            $table->string('applicant_name')->nullable();
            $table->string('applicant_address')->nullable();
            $table->string('building_name')->nullable();
            $table->unsignedBigInteger('locality');
            $table->string('block')->nullable();
            $table->string('plot')->nullable();
            $table->string('known_as')->nullable();
            $table->bigInteger('flat_id')->nullable();
            $table->boolean('isFlatNotListed')->default(false);
            $table->string('flat_number')->nullable();
            $table->string('builder_developer_name')->nullable();
            $table->string('original_buyer_name')->nullable();
            $table->string('present_occupant_name')->nullable();
            $table->string('purchased_from')->nullable();
            $table->date('purchased_date')->nullable();
            $table->string('flat_area')->nullable();
            $table->string('plot_area')->nullable();
            $table->boolean('undertaking')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('locality')->references('id')->on('old_colonies')->onDelete('cascade');
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
        Schema::dropIfExists('deed_of_apartment_applications');
    }
};
