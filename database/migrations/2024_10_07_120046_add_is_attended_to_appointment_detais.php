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
            if (!Schema::hasColumn('appointment_details', 'is_attended')) {
                $table->boolean('is_attended')->after('meeting_timeslot');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            if (Schema::hasColumn('appointment_details', 'is_attended')) {
                $table->dropColumn('is_attended');
            }
        });
    }
};
