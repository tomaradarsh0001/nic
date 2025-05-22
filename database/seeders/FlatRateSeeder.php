<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FlatRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residentialId = DB::table('items')->where('group_id', 1052)->where('item_name', 'Residential')->value('id');
        $commercialId = DB::table('items')->where('group_id', 1052)->where('item_name', 'Commercial')->value('id');

        DB::table('flat_rates')->insert([
            [
                'property_type' => $residentialId,
                'date_from' => '2014-09-23',
                'date_to' => null,
                'rate' => 109800,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'property_type' => $commercialId,
                'date_from' => '2014-09-23',
                'date_to' => null,
                'rate' => 126000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
