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
        Schema::create('user_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->enum('status', ['new', 'approved','rejected']);
            $table->enum('purpose_of_registation', ['allotment', 'existing_property']);
            $table->enum('user_type', ['individual', 'organization']);
            $table->string('name');
            $table->string('gender');
            $table->string('prefix');
            $table->string('second_name');
            $table->string('mobile');
            $table->string('email');
            $table->string('pan_number');
            $table->string('aadhar_number');
            $table->string('comm_address');
            $table->tinyInteger('is_property_id_known')->default(0);
            $table->string('locality');
            $table->string('block');
            $table->string('plot');
            $table->string('flat');
            $table->string('known_as');
            $table->string('section_code');
            $table->string('organization_name');
            $table->string('organization_pan_card');
            $table->string('organization_address');
            $table->string('sale_deed_doc')->nullable();
            $table->string('builder_buyer_agreement_doc')->nullable();
            $table->string('lease_deed_doc')->nullable();
            $table->string('substitution_mutation_letter_doc')->nullable();
            $table->string('owner_lessee_doc')->nullable();
            $table->string('authorised_signatory_doc')->nullable();
            $table->string('chain_of_ownership_doc')->nullable();
            $table->string('consent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_registrations');
    }
};
