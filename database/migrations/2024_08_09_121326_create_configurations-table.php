<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); 
            $table->string('auth_token')->nullable(); 
            $table->string('api')->nullable();
            $table->string('sms_number')->nullable(); 
            $table->string('whatsapp_number')->nullable(); 
            $table->string('email')->nullable(); 
            $table->integer('port')->nullable(); 
            $table->string('host')->nullable(); 
            $table->string('encryption')->nullable(); 
            $table->boolean('status')->default(true); 
            $table->string('created_by')->nullable(); 
            $table->string('updated_by')->nullable(); 
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
