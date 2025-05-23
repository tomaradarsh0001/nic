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
        Schema::create('club_membership_dgcs', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('membership_id'); // Foreign Key referencing club_memberships.id
            $table->boolean('is_post_under_central_staffing_scheme')->nullable(); //need to ask for the field
            $table->string('date_or_details_of_regular_membership')->nullable();
            $table->string('dgc_tenure_period')->nullable();
            $table->date('handicap_certification')->nullable();
            $table->date('ihc_nomination_date')->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('membership_id')->references('id')->on('club_memberships');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_membership_dgcs');
    }
};
