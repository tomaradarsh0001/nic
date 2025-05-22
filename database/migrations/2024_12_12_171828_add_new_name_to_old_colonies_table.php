<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewNameToOldColoniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('old_colonies', function (Blueprint $table) {
            $table->string('new_name')->nullable()->after('name'); // Replace 'existing_column_name' with the name of a column that 'new_name' should follow
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
            $table->dropColumn('new_name');
        });
    }
}
