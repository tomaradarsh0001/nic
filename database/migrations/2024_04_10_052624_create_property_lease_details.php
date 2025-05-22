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
        Schema::create('property_lease_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_master_id')->constrained();
            $table->string('type_of_lease');
            $table->string('lease_no')->nullable();
            $table->date('date_of_expiration')->nullable();
            $table->date('doe')->nullable();
            $table->date('doa')->nullable();
            $table->string('block_number')->nullable();
            $table->string('plot_or_property_number')->nullable();
            $table->string('presently_known_as')->nullable();
            $table->string('plot_area')->nullable();
            $table->string('unit')->nullable();
            $table->string('plot_area_in_sqm')->nullable();
            $table->string('plot_value')->nullable();
            $table->string('premium')->nullable();
            $table->string('gr_in_re_rs')->nullable();
            $table->string('gr_in_paisa')->nullable();
            $table->string('gr_in_aana')->nullable();
            $table->date('start_date_of_gr')->nullable();
            $table->date('first_rgr_due_on')->nullable();
            $table->string('property_type_as_per_lease')->nullable();
            $table->string('property_sub_type_as_per_lease')->nullable();
            $table->boolean('is_land_use_changed')->default(false);
            $table->string('property_type_at_present')->nullable();
            $table->string('property_sub_type_at_present')->nullable();
            $table->date('date_of_conveyance_deed')->nullable();
            $table->string('in_possession_of_if_vacant')->nullable();
            $table->date('date_of_transfer')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('property_lease_details');
    }
};
