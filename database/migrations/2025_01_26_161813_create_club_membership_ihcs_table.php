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
        Schema::create('club_membership_ihcs', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('membership_id'); // Foreign Key referencing club_memberships.id
            $table->date('individual_membership_date')->nullable();
            $table->string('dgc_tenure_period')->nullable();
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
        Schema::dropIfExists('club_membership_ihcs');
    }
};
