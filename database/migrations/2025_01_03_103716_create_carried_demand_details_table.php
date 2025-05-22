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
        Schema::create('carried_demand_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('new_demand_id');
            $table->bigInteger('old_demand_id');
            $table->decimal('carried_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carried_demand_details');
    }
};
