<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            // Change the 'known_as' column to have a default value of null
            $table->string('known_as')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            // Remove the default null if you want to revert the migration
            $table->string('known_as')->nullable(false)->change();
        });
    }
};
