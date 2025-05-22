<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lndo_land_rate')->insert(
            [[
                'old_colony_id'=> 128, 
                'date_from'=> '1966-03-28', 
                'date_to'=> '1972-01-14', 
                'residential_land_rate'=> 47.84, 
                'commercial_land_rate'=> 95.68, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 128, 
                'date_from'=> '1972-01-15', 
                'date_to'=> '1974-04-13', 
                'residential_land_rate'=> 47.84, 
                'commercial_land_rate'=> 95.68, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 128, 
                'date_from'=> '1974-04-14', 
                'date_to'=> '1979-03-31', 
                'residential_land_rate'=> 59.80, 
                'commercial_land_rate'=> 119.60, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],

            [
                'old_colony_id'=> 128, 
                'date_from'=> '1979-04-01', 
                'date_to'=> '1981-03-31', 
                'residential_land_rate'=> 239.20, 
                'commercial_land_rate'=> 478.40, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 128, 
                'date_from'=> '1981-04-01', 
                'date_to'=> '1985-03-31', 
                'residential_land_rate'=> 1052.47, 
                'commercial_land_rate'=> 1913.59, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 128, 
                'date_from'=> '1985-04-01', 
                'date_to'=> '1987-03-31', 
               'residential_land_rate'=> 1052.47, 
                'commercial_land_rate'=> 1913.59, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            //==================================================
            [
                'old_colony_id'=> 196, 
                'date_from'=> '1966-03-28', 
                'date_to'=> '1972-01-14', 
                'residential_land_rate'=> 239.20, 
                'commercial_land_rate'=> 478.40, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 196, 
                'date_from'=> '1972-01-15', 
                'date_to'=> '1974-04-13', 
                'residential_land_rate'=> 239.20, 
                'commercial_land_rate'=> 478.40,
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
           /*  [
                'old_colony_id'=> 196, 
                'date_from'=> '1974-04-14', 
                'date_to'=> '1979-03-31', 
                'residential_land_rate'=> 59.80, 
                'commercial_land_rate'=> 119.60, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ], */

            [
                'old_colony_id'=> 196, 
                'date_from'=> '1979-04-01', 
                'date_to'=> '1981-03-31', 
                'residential_land_rate'=> 478.40, 
                'commercial_land_rate'=> 956.79, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 196, 
                'date_from'=> '1981-04-01', 
                'date_to'=> '1985-03-31', 
                'residential_land_rate'=> 1435.19, 
                'commercial_land_rate'=> 2870.38, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 196, 
                'date_from'=> '1985-04-01', 
                'date_to'=> '1987-03-31', 
               'residential_land_rate'=> 1578.71, 
                'commercial_land_rate'=> 2870.38, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            //==================================================
            [
                'old_colony_id'=> 256, 
                'date_from'=> '1966-03-28', 
                'date_to'=> '1972-01-14', 
                'residential_land_rate'=> 119.60, 
                'commercial_land_rate'=> 239.20, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 256, 
                'date_from'=> '1972-01-15', 
                'date_to'=> '1974-04-13', 
                'residential_land_rate'=> 119.60, 
                'commercial_land_rate'=> 239.20, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 256, 
                'date_from'=> '1974-04-14', 
                'date_to'=> '1979-03-31', 
                'residential_land_rate'=> 209.30, 
                'commercial_land_rate'=> 418.60, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],

            [
                'old_colony_id'=> 256, 
                'date_from'=> '1979-04-01', 
                'date_to'=> '1981-03-31', 
                'residential_land_rate'=> 598, 
                'commercial_land_rate'=> 1196,
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 256, 
                'date_from'=> '1981-04-01', 
                'date_to'=> '1985-03-31', 
                'residential_land_rate'=> 1913.59, 
                'commercial_land_rate'=> 5740.76, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ],
            [
                'old_colony_id'=> 256, 
                'date_from'=> '1985-04-01', 
                'date_to'=> '1987-03-31', 
               'residential_land_rate'=> 2104.94, 
                'commercial_land_rate'=> 5740.76, 
                'institutional_land_rate'=> null, 
                'industrial_land_rate'=> null
            ]]
            //==================================================
            
    );
    }
}
