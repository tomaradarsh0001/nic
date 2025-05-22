<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flat_rates', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->integer('property_type');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->decimal('rate', 12, 2);
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flat_rates');
    }
};
