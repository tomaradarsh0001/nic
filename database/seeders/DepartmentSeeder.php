<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->truncate();
        $departments = [
            [
                'name' => 'Delhi Development Authority', 
                'short_code' => 'DDA', 
                'file_code' => 'TD', 
                'is_active' => 1, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Central Public Works Department', 
                'short_code' => 'CPWD', 
                'file_code' => 'TC', 
                'is_active' => 1, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'New Delhi Municipal Council', 
                'short_code' => 'NDMC', 
                'file_code' => 'TN', 
                'is_active' => 1, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Municipal Corporation of Delhi', 
                'short_code' => 'MCD', 
                'file_code' => 'TM', 
                'is_active' => 1, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('departments')->insert($departments);
    }
}
