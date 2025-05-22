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
        Schema::create('old_demands', function (Blueprint $table) {
            $table->id();
            $table->string('new_demand_id')->nullable();
            $table->string('demand_id');
            $table->string('property_id');
            $table->double('amount', 14, 2);
            $table->double('paid_amount', 14, 2)->nullable();
            $table->double('outstanding', 14, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_demands');
    }
};
