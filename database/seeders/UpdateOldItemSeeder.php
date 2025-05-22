<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateOldItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder is created by Nitin  on 06 March 2025 - 
     * to be used only when we need make chnages in items table
     */
    public function run(): void
    {
        // deactivate old items
        DB::table('items')->where('group_id', 7003)->update(['is_active' => 0]);

        // update data
        $updateData = [
            [
                'where' => [['group_id', '=', 7003], ['item_code', '=', '16']],
                'update' => ['item_code' => 'DEM_UEI', 'is_active' => 1]
            ],
            [
                'where' => [['group_id', '=', 7003], ['item_code', '=', '67']],
                'update' => ['item_code' => 'DEM_AF_P', 'item_name' => 'Allotment Fees or Premium', 'is_active' => 1]
            ],
            [
                'where' => [['group_id', '=', 7003], ['item_code', '=', '14']],
                'update' => ['item_code' => 'DEM_RGR', 'item_name' => 'Revised Ground Rent or Revised License Fees', 'is_active' => 1]
            ],
            [
                'where' => [['group_id', '=', 7003], ['item_code', '=', 'LIC_FEE']],
                'update' => ['item_code' => 'DEM_LF_GR', 'item_name' => 'License Fees or Ground Rent', 'is_active' => 1]
            ],
            [
                'where' => [['group_id', '=', 7003], ['item_code', '=', 'PREV_DUE']],
                'update' => ['is_active' => 1]
            ],
            [
                'where' => [['group_id', '=', 7003], ['item_code', '=', 'OTH_CHG']],
                'update' => ['item_code' => 'DEM_OTHER', 'is_active' => 1, 'item_order' => 2]
            ],
        ];
        // update data for selected items
        foreach ($updateData as $row) {
            DB::table('items')->where($row['where'])->update($row['update']);
        }
    }
}
