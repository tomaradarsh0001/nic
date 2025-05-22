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
        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id');
            $table->foreignId('splited_property_detail_id')->nullable();
            $table->integer('master_old_property_id');
            $table->integer('splited_old_property_id')->nullable();
            $table->decimal('amount', total: 12, places: 2)->nullable();
            $table->decimal('forwarded_amount', total: 12, places: 2)->nullable();
            $table->foreignId('forwarded_from_id')->nullable()->constrained('demands');
            $table->decimal('balance_amount', total: 12, places: 2)->nullable();
            $table->enum('status', ['pending', 'partially paid', 'paid', 'withdrawn', 'forwarded'])->nullable();
            $table->foreignId('created_by');
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demands');
    }
};
