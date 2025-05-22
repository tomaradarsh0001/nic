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
        Schema::create('applicant_user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('user_sub_type', ['individual', 'organization'])->nullable();
            $table->string('gender')->nullable();
            $table->string('so_do_spouse')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('aadhar_card')->nullable();
            $table->string('address')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('organization_pan_card')->nullable();
            $table->string('organization_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_user_details');
    }
};
