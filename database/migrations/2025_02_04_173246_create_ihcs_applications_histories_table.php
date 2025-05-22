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
        Schema::create('ihcs_applications_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_app_id')->constrained('club_membership_applications');
            $table->foreignId('ihc_app_id')->constrained('ihcs_applications');
            $table->string('individual_membership_date_and_remark')->nullable();
            $table->string('new_individual_membership_date_and_remark')->nullable();
            $table->date('dgc_tenure_start_date')->nullable();
            $table->date('new_dgc_tenure_start_date')->nullable();
            $table->date('dgc_tenure_end_date')->nullable();
            $table->date('new_dgc_tenure_end_date')->nullable();
            $table->string('ihcs_doc')->nullable();
            $table->string('new_ihcs_doc')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ihcs_applications_histories');
    }
};
