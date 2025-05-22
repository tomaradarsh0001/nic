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
        Schema::create('mutation_application_histories', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->integer('status')->nullable();
            $table->integer('new_status')->nullable();
            $table->integer('status_of_applicant')->nullable();
            $table->integer('new_status_of_applicant')->nullable();
            $table->string('name_as_per_lease_conv_deed')->nullable();
            $table->string('new_name_as_per_lease_conv_deed')->nullable();
            $table->string('father_name_as_per_lease_conv_deed')->nullable();
            $table->string('new_father_name_as_per_lease_conv_deed')->nullable();
            $table->integer('reg_no_as_per_lease_conv_deed')->nullable();
            $table->integer('new_reg_no_as_per_lease_conv_deed')->nullable();
            $table->integer('book_no_as_per_lease_conv_deed')->nullable();
            $table->integer('new_book_no_as_per_lease_conv_deed')->nullable();
            $table->integer('volume_no_as_per_lease_conv_deed')->nullable();
            $table->integer('new_volume_no_as_per_lease_conv_deed')->nullable();
            $table->integer('page_no_as_per_lease_conv_deed')->nullable();
            $table->integer('new_page_no_as_per_lease_conv_deed')->nullable();
            $table->date('reg_date_as_per_lease_conv_deed')->nullable();
            $table->date('new_reg_date_as_per_lease_conv_deed')->nullable();
            $table->string('sought_on_basis_of_documents')->nullable();
            $table->string('new_sought_on_basis_of_documents')->nullable();
            $table->boolean('property_stands_mortgaged')->nullable();
            $table->boolean('new_property_stands_mortgaged')->nullable();
            $table->string('mortgaged_remark')->nullable();
            $table->string('new_mortgaged_remark')->nullable();
            $table->boolean('is_basis_of_court_order')->nullable();
            $table->boolean('new_is_basis_of_court_order')->nullable();
            $table->string('court_case_no')->nullable();
            $table->string('new_court_case_no')->nullable();
            $table->text('court_case_details')->nullable();
            $table->text('new_court_case_details')->nullable();
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
        Schema::dropIfExists('mutation_application_histories');
    }
};
