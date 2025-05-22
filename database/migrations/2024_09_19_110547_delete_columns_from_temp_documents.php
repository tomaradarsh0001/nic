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
            $table->dropColumn('date_of_attestation');
            $table->dropColumn('attested_by');
            $table->dropColumn('name_of_deceased');
            $table->dropColumn('date_of_death');
            $table->dropColumn('date_of_issue');
            $table->dropColumn('document_certificate_no');
            $table->dropColumn('registration_no');
            $table->dropColumn('volume');
            $table->dropColumn('book_no');
            $table->dropColumn('page_from_to');
            $table->dropColumn('regn_date');
            $table->dropColumn('regn_office_name');
            $table->dropColumn('name_of_testator');
            $table->dropColumn('date_of_will_codicil');
            $table->dropColumn('date_of_execution');
            $table->dropColumn('name_of_court');
            $table->dropColumn('date_of_court_order');
            $table->dropColumn('certificate_no');
            $table->dropColumn('name_of_lessee');
            $table->dropColumn('name_of_newspaper_english');
            $table->dropColumn('name_of_newspaper_hindi');
            $table->dropColumn('date_of_public_notice');
            $table->dropColumn('name_of_executor');
            $table->dropColumn('other_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_documents', function (Blueprint $table) {
            //
        });
    }
};
