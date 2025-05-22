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
        Schema::create('application_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_by');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('current_user_id')->nullable();
            $table->integer('service_type')->comment('Item table primary key search through item_name ex: registration');
            $table->integer('model_id')->comment('primary key of model');
            $table->integer('status');
            $table->string('application_no')->comment('Like registration number from user_registration');
            $table->text('remarks')->nullable();
            $table->string('suggested_property_id')->nullable();
            $table->string('old_property_id')->nullable();
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_movements');
    }
};
