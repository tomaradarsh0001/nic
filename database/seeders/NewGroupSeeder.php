<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            ['group_id' => 17008, 'group_name' => 'Demand Status'],
            ['group_id' => 17009, 'group_name' => 'Payment Status'],
            ['group_id' => 17010, 'group_name' => 'Payment Modes'],
            ['group_id' => 17011, 'group_name' => 'Payment Types'],
        ];
        foreach ($groups as $group) {
            DB::table('groups')->updateOrInsert(
                [
                    'group_id' => $group['group_id'],
                ],
                [
                    'group_name' => $group['group_name'],
                    'is_active' => 1
                ]
            );
        }
    }
}
