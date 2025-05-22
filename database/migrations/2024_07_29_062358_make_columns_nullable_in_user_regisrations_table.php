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
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->string('flat')->nullable()->change();
            $table->string('organization_name')->nullable()->change();
            $table->string('organization_pan_card')->nullable()->change();
            $table->string('organization_address')->nullable()->change();
            $table->string('is_property_id_known')->nullable()->change();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->string('flat')->nullable(false)->change();
            $table->string('organization_name')->nullable(false)->change();
            $table->string('organization_pan_card')->nullable(false)->change();
            $table->string('organization_address')->nullable(false)->change();
            
        });
    }
};
