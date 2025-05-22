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
        Schema::create('club_memberships', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('category');
            $table->string('name');
            $table->string('designation');
            $table->string('designation_equivalent_to');
            $table->string('mobile');
            $table->string('email');
            $table->string('name_of_service');
            $table->integer('year_of_allotment');
            $table->enum('club_type', ['DGC', 'IHC']);
            $table->date('date_of_joining_central_deputation');
            $table->date('expected_date_of_tenure_completion');
            $table->date('date_of_superannuation');
            $table->string('office_address');
            $table->string('pay_scale');
            $table->string('present_previous_membership_of_other_clubs')->nullable();
            $table->string('other_relevant_information')->nullable();
            $table->boolean('consent');
            $table->unsignedBigInteger('status')->default(1501); // Foreign Key with default value
            $table->text('remark')->nullable();
            $table->timestamps();

            // Define foreign key constraint without cascading on delete
            $table->foreign('status')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_memberships');
    }
};
