<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            // Adding the new column after 'locality'
            $table->integer('dealing_section_code', false, true)->after('locality');
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
            // Dropping the column during rollback
            $table->dropColumn('dealing_section_code');
        });
    }
};
