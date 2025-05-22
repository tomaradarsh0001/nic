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
        Schema::table('appointment_details', function (Blueprint $table) {
            //
            Schema::table('appointment_details', function (Blueprint $table) {
                // Modify `meeting_timeslot` using Laravel's standard method
                $table->string('meeting_timeslot')->change();
            });
        
            // Use raw SQL to change `nature_of_visit` to an ENUM
            DB::statement("ALTER TABLE appointment_details MODIFY nature_of_visit ENUM('Online', 'Offline')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            // Modify `meeting_timeslot` back to `time` type using Laravel's standard method
            $table->time('meeting_timeslot')->change();
        });
    
        // Use raw SQL to revert `nature_of_visit` back to its original ENUM
        DB::statement("ALTER TABLE appointment_details MODIFY nature_of_visit ENUM('Office-Visit(In-person)', 'E-hearing(Online)')");
    }
};
