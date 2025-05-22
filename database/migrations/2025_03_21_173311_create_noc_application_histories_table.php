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
        Schema::create('noc_application_histories', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->integer('status')->nullable();
            $table->integer('new_status')->nullable();
            $table->integer('status_of_applicant')->nullable();
            $table->integer('new_status_of_applicant')->nullable();
            $table->string('name_as_per_noc_conv_deed')->nullable();
            $table->string('new_name_as_per_noc_conv_deed')->nullable();
            $table->date('executed_on_as_per_noc_conv_deed')->nullable();
            $table->date('new_executed_on_as_per_noc_conv_deed')->nullable();
            $table->string('reg_no_as_per_noc_conv_deed')->nullable();
            $table->string('new_reg_no_as_per_noc_conv_deed')->nullable();
            $table->string('book_no_as_per_noc_conv_deed')->nullable();
            $table->string('new_book_no_as_per_noc_conv_deed')->nullable();
            $table->string('volume_no_as_per_noc_conv_deed')->nullable();
            $table->string('new_volume_no_as_per_noc_conv_deed')->nullable();
            $table->string('page_no_as_per_noc_conv_deed')->nullable();
            $table->string('new_page_no_as_per_noc_conv_deed')->nullable();
            $table->date('reg_date_as_per_noc_conv_deed')->nullable();
            $table->date('new_reg_date_as_per_noc_conv_deed')->nullable();
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
        Schema::dropIfExists('noc_application_histories');
    }
};