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
        Schema::create('section_mis_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('service_type');
            $table->integer('model_id');
            $table->string('section_code');
            $table->integer('old_property_id');
            $table->string('new_property_id');
            $table->foreignId('property_master_id')->constrained();
            $table->integer('permission_by')->nullable();
            $table->integer('permission_to')->nullable();
            $table->dateTime('permission_at')->nullable();
            $table->boolean('is_active')->default(false);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_mis_histories');
    }
};
