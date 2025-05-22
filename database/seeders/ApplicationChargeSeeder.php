<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApplicationChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Truncate the application_charges table to remove existing data
        DB::table('application_charges')->truncate();

        // Define item codes
        $itemCodes = ['SUB_MUT', 'LUC', 'DOA', 'CONVERSION'];

        // Prepare the common data
        $commonData = [
            'effective_date_from' => Carbon::now()->startOfYear()->toDateString(),
            'effective_date_to' => Carbon::now()->endOfYear()->toDateString(),
            'amount' => 2000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        foreach ($itemCodes as $itemCode) {
            $itemId = DB::table('items')->where('item_code', $itemCode)->pluck('id')->first(); // Fetch the first ID
            if ($itemId) {
                DB::table('application_charges')->insert(array_merge($commonData, [
                    'service_type' => $itemId,
                ]));
            }
        }
        
    }
}
