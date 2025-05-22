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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            //Comment due to countries table is using in both for Payment demand & for User Registration fro sending Code
            // $table->char('iso', 2);
            // $table->string('name', 80);
            // $table->char('iso3', 3)->nullable();
            // $table->smallinteger('numcode')->nullable();
            // $table->integer('phonecode');
            $table->string('name');
            $table->string('iso3');
            $table->string('iso2');
            $table->string('phonecode');
            $table->string('capital');
            $table->string('currency');
            $table->string('currency_symbol');
            $table->string('tld');
            $table->string('native')->nullable();
            $table->string('region');
            $table->string('subregion');
            $table->text('timezones');
            $table->text('translations')->nullable();
            $table->text('latitude');
            $table->text('longitude');
            $table->text('emoji');
            $table->text('emojiU');
            $table->boolean('flag')->default(false);
            $table->text('wikiDataId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
