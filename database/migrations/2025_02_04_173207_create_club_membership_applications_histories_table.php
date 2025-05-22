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
        Schema::create('club_membership_applications_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_app_id')->constrained('club_membership_applications'); // Ensure the table name is correct
            $table->date('date_of_application')->nullable();
            $table->date('new_date_of_application')->nullable();
            $table->string('category')->nullable();
            $table->string('new_category')->nullable();
            $table->string('other_category')->nullable();
            $table->string('new_other_category')->nullable();
            $table->string('name')->nullable();
            $table->string('new_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('new_designation')->nullable();
            $table->string('designation_equivalent_to')->nullable();
            $table->string('new_designation_equivalent_to')->nullable();
            $table->string('other_designation_equivalent_to')->nullable();
            $table->string('new_other_designation_equivalent_to')->nullable();
            $table->string('department')->nullable();
            $table->string('new_department')->nullable();
            $table->string('mobile')->nullable();
            $table->string('new_mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('new_email')->nullable();
            $table->string('name_of_service')->nullable();
            $table->string('new_name_of_service')->nullable();
            $table->integer('year_of_allotment')->nullable();
            $table->integer('new_year_of_allotment')->nullable();
            $table->enum('club_type', ['DGC', 'IHC'])->nullable();
            $table->enum('new_club_type', ['DGC', 'IHC'])->nullable();
            $table->date('date_of_joining_central_deputation')->nullable();
            $table->date('new_date_of_joining_central_deputation')->nullable();
            $table->date('expected_date_of_tenure_completion')->nullable();
            $table->date('new_expected_date_of_tenure_completion')->nullable();
            $table->date('date_of_superannuation')->nullable();
            $table->date('new_date_of_superannuation')->nullable();
            $table->string('office_address')->nullable();
            $table->string('new_office_address')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('new_telephone_no')->nullable();
            $table->string('pay_scale')->nullable();
            $table->string('new_pay_scale')->nullable();
            $table->string('present_previous_membership_of_other_clubs')->nullable();
            $table->string('new_present_previous_membership_of_other_clubs')->nullable();
            $table->string('other_relevant_information')->nullable();
            $table->string('new_other_relevant_information')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_membership_applications_histories');
    }
};
