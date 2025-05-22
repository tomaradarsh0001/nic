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
        Schema::table('temp_documents', function (Blueprint $table) {
            $table->date('date_of_attestation')->nullable()->change();
            $table->string('attested_by')->nullable()->change();
            $table->string('name_of_deceased')->nullable()->change();
            $table->date('date_of_death')->nullable()->change();
            $table->date('date_of_issue')->nullable()->change();
            $table->string('document_certificate_no')->nullable()->change();
            $table->integer('registration_no')->nullable()->change();
            $table->integer('volume')->nullable()->change();
            $table->integer('book_no')->nullable()->change();
            $table->string('page_from_to')->nullable()->change();
            $table->date('regn_date')->nullable()->change();
            $table->string('regn_office_name')->nullable()->change();
            $table->string('name_of_testator')->nullable()->change();
            $table->date('date_of_will_codicil')->nullable()->change();
            $table->date('date_of_execution')->nullable()->change();
            $table->string('name_of_court')->nullable()->change();
            $table->date('date_of_court_order')->nullable()->change();
            $table->string('certificate_no')->nullable()->change();
            $table->string('name_of_lessee')->nullable()->change();
            $table->string('name_of_newspaper_english')->nullable()->change();
            $table->string('name_of_newspaper_hindi')->nullable()->change();
            $table->date('date_of_public_notice')->nullable()->change();
            $table->string('name_of_executor')->nullable()->change();
            $table->string('other_details')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_documents', function (Blueprint $table) {
            $table->date('date_of_attestation')->nullable(false)->change();
            $table->string('attested_by')->nullable(false)->change();
            $table->string('name_of_deceased')->nullable(false)->change();
            $table->date('date_of_death')->nullable(false)->change();
            $table->date('date_of_issue')->nullable(false)->change();
            $table->string('document_certificate_no')->nullable(false)->change();
            $table->integer('registration_no')->nullable(false)->change();
            $table->integer('volume')->nullable(false)->change();
            $table->integer('book_no')->nullable(false)->change();
            $table->string('page_from_to')->nullable(false)->change();
            $table->date('regn_date')->nullable(false)->change();
            $table->string('regn_office_name')->nullable(false)->change();
            $table->string('name_of_testator')->nullable(false)->change();
            $table->date('date_of_will_codicil')->nullable(false)->change();
            $table->date('date_of_execution')->nullable(false)->change();
            $table->string('name_of_court')->nullable(false)->change();
            $table->date('date_of_court_order')->nullable(false)->change();
            $table->string('certificate_no')->nullable(false)->change();
            $table->string('name_of_lessee')->nullable(false)->change();
            $table->string('name_of_newspaper_english')->nullable(false)->change();
            $table->string('name_of_newspaper_hindi')->nullable(false)->change();
            $table->date('date_of_public_notice')->nullable(false)->change();
            $table->string('name_of_executor')->nullable(false)->change();
            $table->string('other_details')->nullable(false)->change();
        });
    }
};
