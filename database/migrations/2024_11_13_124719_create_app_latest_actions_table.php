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
        Schema::create('app_latest_actions', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->string('prev_action')->nullable();
            $table->integer('prev_action_by')->nullable();
            $table->string('latest_action');
            $table->integer('latest_action_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_latest_actions');
    }
};
