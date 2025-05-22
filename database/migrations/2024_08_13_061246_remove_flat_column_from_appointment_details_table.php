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
            $table->dropColumn('flat');

            $table->string('stakeholder_doc')->nullable()->change();
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
            $table->string('flat')->nullable(); // Add the column back if rolled back

            $table->string('stakeholder_doc')->nullable(false)->change();
        });
    }
};
