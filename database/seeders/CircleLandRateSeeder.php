<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CircleLandRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cirle_land_rate')->insert(
            [
                [
                    'old_colony_id' => 68,
                    'date_from' => null,
                    'date_to' => '2007-07-18',
                    'residential_land_rate' => 0,
                    'commercial_land_rate' => 0,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ],
                [
                    'old_colony_id' => 68,
                    'date_from' => '2007-07-18',
                    'date_to' => '2014-09-23',
                    'residential_land_rate' => 27300,
                    'commercial_land_rate' => 81900,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ],
                [
                    'old_colony_id' => 68,
                    'date_from' => '2014-09-23',
                    'date_to' => null,
                    'residential_land_rate' => 159840,
                    'commercial_land_rate' => 479520,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ],

                //==================================================
                [
                    'old_colony_id' => 77,
                    'date_from' => null,
                    'date_to' => '2007-07-18',
                    'residential_land_rate' => 0,
                    'commercial_land_rate' => 0,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ],
                [
                    'old_colony_id' => 77,
                    'date_from' => '2007-07-18',
                    'date_to' => '2014-09-23',
                    'residential_land_rate' => 34100,
                    'commercial_land_rate' => 102300,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ],
                [
                    'old_colony_id' => 77,
                    'date_from' => '2014-09-23',
                    'date_to' => null,
                    'residential_land_rate' => 245520,
                    'commercial_land_rate' => 736560,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ],
                //==================================================
                [
                    'old_colony_id' => 244,
                    'date_from' => null,
                    'date_to' => '2007-07-18',
                    'residential_land_rate' => 0,
                    'commercial_land_rate' => 0,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ],
                [
                    'old_colony_id' => 244,
                    'date_from' => '2007-07-18',
                    'date_to' => '2014-09-23',
                    'residential_land_rate' => 27300,
                    'commercial_land_rate' => 81900,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ],
                [
                    'old_colony_id' => 244,
                    'date_from' => '2014-09-23',
                    'date_to' => null,
                    'residential_land_rate' => 159840,
                    'commercial_land_rate' => 479520,
                    'institutional_land_rate' => null,
                    'industrial_land_rate' => null
                ]
            ]
            //==================================================

        );
    }
}
