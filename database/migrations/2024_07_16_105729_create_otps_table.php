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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->enum('is_email_verified', ['0', '1'])->default('0')->nullable();
            $table->dateTime('email_otp_sent_at')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('mobile');
            $table->enum('is_mobile_verified', ['0', '1'])->default('0')->nullable();
            $table->dateTime('mobile_otp_sent_at')->nullable();
            $table->dateTime('mobile_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
