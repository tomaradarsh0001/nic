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
        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // Rename the column from property_id to old_property_id
            $table->renameColumn('property_id', 'old_property_id');
            $table->renameColumn('ticket_id', 'unique_id');
            
            // Change the datatype of the status column from enum to int
            DB::statement("ALTER TABLE admin_public_grievances MODIFY status INT DEFAULT 1377 NOT NULL");
        });
    }

    public function down()
    {
        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // Revert the column name change
            $table->renameColumn('old_property_id', 'property_id');
            $table->renameColumn('unique_id', 'ticket_id');
            
            // Revert the status column back to enum
            DB::statement("ALTER TABLE admin_public_grievances MODIFY status ENUM('new', 'in_process', 'resolved', 'cancelled', 'reopen') DEFAULT 'new'");
        });
    }
};
