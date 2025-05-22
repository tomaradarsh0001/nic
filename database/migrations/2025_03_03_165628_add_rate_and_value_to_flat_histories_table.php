<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('flat_histories', function (Blueprint $table) {
            $table->decimal('rate', 12, 2)->nullable()->after('new_area_in_sqm');
            $table->decimal('new_rate', 12, 2)->nullable()->after('rate');
            $table->decimal('value', 12, 2)->nullable()->after('new_rate');
            $table->decimal('new_value', 12, 2)->nullable()->after('value');
        });
    }

    public function down()
    {
        Schema::table('flat_histories', function (Blueprint $table) {
            $table->dropColumn(['rate', 'new_rate', 'value', 'new_value']);
        });
    }
};
