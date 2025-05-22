<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            $table->string('is_attended')->nullable()->default(null)->after('meeting_timeslot')->change();
        });
    }

    public function down()
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            $table->string('is_attended')->nullable(false)->default(0)->after('meeting_timeslot')->change();
        });
    }
};
