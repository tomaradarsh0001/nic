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
        Schema::create('dgcs_applications_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_app_id')->constrained('club_membership_applications');
            $table->foreignId('dgc_app_id')->constrained('dgcs_applications');
            $table->string('is_post_under_central_staffing_scheme')->nullable();
            $table->string('new_is_post_under_central_staffing_scheme')->nullable();
            $table->string('regular_membership_date_and_remark')->nullable();
            $table->string('new_regular_membership_date_and_remark')->nullable();
            $table->date('dgc_tenure_start_date')->nullable();
            $table->date('new_dgc_tenure_start_date')->nullable();
            $table->date('dgc_tenure_end_date')->nullable();
            $table->date('new_dgc_tenure_end_date')->nullable();
            $table->date('handicap_certification_date')->nullable();
            $table->date('new_handicap_certification_date')->nullable();
            $table->date('ihc_nomination_date')->nullable();
            $table->date('new_ihc_nomination_date')->nullable();
            $table->string('dgcs_doc')->nullable();
            $table->string('new_dgcs_doc')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dgcs_applications_histories');
    }
};
