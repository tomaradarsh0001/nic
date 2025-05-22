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
        Schema::create('demand_formulas', function (Blueprint $table) {
            $table->id();
            $table->string('head_code', 20);
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->text('formula');
            $table->text('description')->nullable();
            $table->tinyInteger('for_allotment_type')->comment('0- for existing allotment, 1- for new allotment, 2- both')->default(0);
            $table->string('parent_head_code', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demand_formulas');
    }
};
