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
        Schema::create('appointment_details', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('pan_number');
            $table->string('locality');
            $table->string('block');
            $table->string('plot');
            $table->string('flat');
            $table->string('known_as');
            $table->boolean('is_stakeholder')->default(0);
            $table->string('stakeholder_doc');
            $table->enum('nature_of_visit', ['Office-Visit(In-person)', 'E-hearing(Online)']);
            $table->string('meeting_purpose');
            $table->date('meeting_date');
            $table->time('meeting_timeslot');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('remark')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_details');
    }
};
