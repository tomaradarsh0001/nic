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
        Schema::table('property_contact_details_histories', function (Blueprint $table) {
            $table->date('as_on_date')->nullable()->after('new_email');
            $table->date('new_as_on_date')->nullable()->after('as_on_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_contact_details_histories', function (Blueprint $table) {
            //
        });
    }
};
