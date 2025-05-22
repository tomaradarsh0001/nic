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
        Schema::create('grievance_remarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grievance_id');
            $table->integer('status');
            $table->string('remark');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('grievance_id')->references('id')->on('admin_public_grievances');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievance_remarks');
    }
};
