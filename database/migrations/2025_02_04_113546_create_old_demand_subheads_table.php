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
        Schema::create('old_demand_subheads', function (Blueprint $table) {
            $table->id();
            $table->string('DemandID');
            $table->string('ComputerCode')->nullable();
            $table->string('Subhead')->nullable();
            $table->date('DateFrom')->nullable();
            $table->date('DateTo')->nullable();
            $table->string('InterestSlab')->nullable();
            $table->double('InterestSlabAmount', 14, 2)->nullable();
            $table->double('Rate', 14, 2)->nullable();
            $table->double('Amount', 14, 2)->nullable();
            $table->string('PaymentStatus', 5)->nullable();
            $table->string('BreachType', 5)->nullable();
            $table->string('Floor', 5)->nullable();
            $table->float('Area', 14, 5)->nullable();
            $table->string('AreaUnit', 5)->nullable();
            $table->string('PaymentType', 5)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_demand_subheads');
    }
};
