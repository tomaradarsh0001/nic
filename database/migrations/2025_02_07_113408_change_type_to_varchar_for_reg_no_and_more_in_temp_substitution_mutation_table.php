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
        Schema::table('temp_substitution_mutation', function (Blueprint $table) {
            $table->string('reg_no_as_per_lease_conv_deed', 255)->change();
            $table->string('book_no_as_per_lease_conv_deed', 255)->change();
            $table->string('volume_no_as_per_lease_conv_deed', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_substitution_mutation', function (Blueprint $table) {
            $table->integer('reg_no_as_per_lease_conv_deed')->change();
            $table->integer('book_no_as_per_lease_conv_deed')->change();
            $table->integer('volume_no_as_per_lease_conv_deed')->change();
        });
    }
};
