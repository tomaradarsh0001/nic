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
        Schema::create('temp_nocs', function (Blueprint $table) {
            $table->id();
            $table->integer('old_property_id');
            $table->string('new_property_id');
            $table->integer('property_master_id');
            $table->integer('property_status');
            $table->integer('status_of_applicant');
            $table->string('name_as_per_noc_conv_deed');
            $table->date('executed_on_as_per_noc_conv_deed');
            $table->string('reg_no_as_per_noc_conv_deed');
            $table->string('book_no_as_per_noc_conv_deed');
            $table->string('volume_no_as_per_noc_conv_deed');
            $table->string('page_no_as_per_noc_conv_deed');
            $table->date('reg_date_as_per_noc_conv_deed');
            $table->boolean('undertaking')->nullable();
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
        Schema::dropIfExists('temp_nocs');
    }
};
