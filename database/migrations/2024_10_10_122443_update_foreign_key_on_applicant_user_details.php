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
        Schema::table('applicant_user_details', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the existing foreign key constraint
    
            // Re-add the foreign key with ON DELETE CASCADE
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_user_details', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the cascade foreign key
    
            // Re-add the foreign key without cascading delete
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }
};
