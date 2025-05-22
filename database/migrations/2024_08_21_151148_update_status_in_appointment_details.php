<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE appointment_details MODIFY COLUMN status ENUM('Approved', 'Rejected', 'Completed') DEFAULT 'Approved'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE appointment_details MODIFY COLUMN status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending'");
    }
};
