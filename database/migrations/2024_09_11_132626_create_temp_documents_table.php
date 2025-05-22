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
        Schema::create('temp_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('service_type');
            $table->string('model_name');
            $table->integer('model_id');
            $table->string('title');
            $table->string('document_type');
            $table->string('file_path');
            $table->date('date_of_attestation');
            $table->string('attested_by');
            $table->string('name_of_deceased');
            $table->date('date_of_death');
            $table->date('date_of_issue');
            $table->string('document_certificate_no');
            $table->integer('registration_no');
            $table->integer('volume');
            $table->integer('book_no');
            $table->string('page_from_to');
            $table->date('regn_date');
            $table->string('regn_office_name');
            $table->string('name_of_testator');
            $table->date('date_of_will_codicil');
            $table->date('date_of_execution');
            $table->string('name_of_court');
            $table->date('date_of_court_order');
            $table->string('certificate_no');
            $table->string('name_of_lessee');
            $table->string('name_of_newspaper_english');
            $table->string('name_of_newspaper_hindi');
            $table->date('date_of_public_notice');
            $table->string('name_of_executor');
            $table->string('other_details');

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
        Schema::dropIfExists('temp_documents');
    }
};
