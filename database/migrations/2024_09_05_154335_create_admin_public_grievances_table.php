<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPublicGrievancesTable extends Migration
{
    public function up()
    {
        Schema::create('admin_public_grievances', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('communication_address');
            $table->string('colony');
            $table->string('property_id')->nullable();
            $table->integer('dealing_section_code');
            $table->text('description');
            $table->string('recording');
            $table->string('remark')->nullable();
            $table->enum('status', ['new', 'in_process', 'resolved', 'cancelled', 'reopen'])->default('new');
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by');
            
        });

    }

    public function down()
    {

        Schema::dropIfExists('admin_public_grievances');
    }
}
