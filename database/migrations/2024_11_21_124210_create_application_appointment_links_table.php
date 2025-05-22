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
        Schema::create('application_appointment_links', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->string('link');
            $table->date('schedule_date')->nullable();
            $table->date('valid_till');
            $table->boolean('is_attended')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_appointment_links');
    }
};
