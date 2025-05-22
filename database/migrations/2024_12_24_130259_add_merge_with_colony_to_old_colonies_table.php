<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('old_colonies', function (Blueprint $table) {
            $table->bigInteger('merge_with_colony')->nullable()->after('related_colonies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('old_colonies', function (Blueprint $table) {
            $table->dropColumn('merge_with_colony');
        });
    }
};
