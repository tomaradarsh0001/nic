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
        Schema::create('application_charges', function (Blueprint $table) {
            $table->id();
            $table->integer('service_type');
            $table->date('effective_date_from')->nullable();
            $table->date('effective_date_to')->nullable();
            $table->double('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_charges');
    }
};
