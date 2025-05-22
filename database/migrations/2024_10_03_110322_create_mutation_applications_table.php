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
        Schema::create('mutation_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->integer('old_property_id');
            $table->string('new_property_id');
            $table->integer('property_master_id');
            $table->integer('property_status');
            $table->integer('status_of_applicant');
            $table->string('name_as_per_lease_conv_deed');
            $table->string('father_name_as_per_lease_conv_deed');
            $table->integer('reg_no_as_per_lease_conv_deed');
            $table->integer('book_no_as_per_lease_conv_deed');
            $table->integer('volume_no_as_per_lease_conv_deed');
            $table->integer('page_no_as_per_lease_conv_deed');
            $table->date('reg_date_as_per_lease_conv_deed');
            $table->integer('sought_on_basis_of');
            $table->boolean('property_stands_mortgaged');
            $table->string('mortgaged_remark')->nullable();
            $table->boolean('is_basis_of_court_order');
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
        Schema::dropIfExists('mutation_applications');
    }
};
