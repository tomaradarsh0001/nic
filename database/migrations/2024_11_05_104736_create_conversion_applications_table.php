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
        Schema::create('conversion_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->nullable();
            $table->smallInteger('status')->nullable();
            $table->integer('old_property_id');
            $table->string('new_property_id')->nullable();
            $table->integer('property_master_id');
            $table->integer('splited_property_detail_id')->nullable();
            $table->integer('flat_id')->nullable();
            $table->smallInteger('status_of_applicant');
            $table->string('applicant_name');
            $table->string('relation_prefix')->nullable();
            $table->string('relation_name')->nullable();
            $table->date('executed_on');
            $table->integer('reg_no');
            $table->integer('book_no');
            $table->integer('volume_no');
            $table->string('page_no');
            $table->date('reg_date');
            $table->boolean('is_court_order');
            $table->string('case_no')->nullable();
            $table->string('case_detail')->nullable();
            $table->boolean('is_mortgaged')->nullable()->default(false);
            $table->boolean('is_Lease_deed_lost')->nullable()->default(false);
            $table->boolean('consent')->nullable();
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
        Schema::dropIfExists('conversion_applications');
    }
};
