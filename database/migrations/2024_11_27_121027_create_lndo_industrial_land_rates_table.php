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
        Schema::create('lndo_industrial_land_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colony_id');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->decimal('land_rate', total: 12, places: 2)->nullable();
            $table->foreignId('created_by');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lndo_industrial_land_rates');
    }
};
