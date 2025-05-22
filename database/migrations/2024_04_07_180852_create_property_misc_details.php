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
        Schema::create('property_misc_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->integer('old_property_id');
            $table->boolean('is_gr_revised_ever')->default(false);
            $table->date('gr_revised_date')->nullable();
            $table->boolean('is_supplimentry_lease_deed_executed')->default(false);
            $table->date('supplimentry_lease_deed_executed_date')->nullable();
            $table->boolean('is_re_rented')->default(false);
            $table->date('re_rented_date')->nullable();
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('property_misc_details');
    }
};
