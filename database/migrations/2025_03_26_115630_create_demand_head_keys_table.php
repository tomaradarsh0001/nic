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
        Schema::create('demand_head_keys', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('demand_id');
            $table->bigInteger('head_id')->nullable();
            $table->string('key');
            $table->string('value', 2000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demand_head_keys');
    }
};
