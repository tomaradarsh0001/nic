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
        Schema::create('colonies', function (Blueprint $table) {
            $table->id();
            $table->string('old_name');
            $table->string('new_name');
            $table->string('old_col_code');
            $table->string('new_col_code');
            $table->string('zone_code');
            $table->string('land_type');
            $table->string('land_circle_rate');
            $table->string('dealing_section_code')->nullable();
            $table->boolean('is_active')->default(true);
            
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
        Schema::dropIfExists('colonies');
    }
};
