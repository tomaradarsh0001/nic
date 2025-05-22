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
        Schema::create('property_misc_detail_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->boolean('is_gr_revised_ever')->nullable();
            $table->boolean('new_is_gr_revised_ever')->nullable();
            $table->date('gr_revised_date')->nullable();
            $table->date('new_gr_revised_date')->nullable();
            $table->boolean('is_supplimentry_lease_deed_executed')->nullable();
            $table->boolean('new_is_supplimentry_lease_deed_executed')->nullable();
            $table->date('supplimentry_lease_deed_executed_date')->nullable();
            $table->date('new_supplimentry_lease_deed_executed_date')->nullable();
            $table->boolean('is_re_rented')->nullable();
            $table->boolean('new_is_re_rented')->nullable();
            $table->date('re_rented_date')->nullable();
            $table->date('new_re_rented_date')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('new_is_active')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_misc_detail_histories');
    }
};
