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
        Schema::create('temp_coapplicants', function (Blueprint $table) {
            $table->id();
            $table->integer('service_type');
            $table->string('model_name');
            $table->integer('model_id');
            $table->string('co_applicant_name');
            $table->string('co_applicant_gender');
            $table->integer('co_applicant_age');
            $table->string('co_applicant_father_name');
            $table->string('co_applicant_aadhar');
            $table->string('co_applicant_pan');
            $table->string('co_applicant_mobile');
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
        Schema::dropIfExists('temp_coapplicants');
    }
};
