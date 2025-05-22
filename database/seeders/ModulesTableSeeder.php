<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('modules')->truncate();
        $modules = [
            ['name' => 'propertyProfarma', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'logistics', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'settings', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'users', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'roles', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'permissions', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'logisticCategories', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'logisticItems', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'vendors', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'importLAndDoRates', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'importCircleRates', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'searchProperty', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'login', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'logout', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'purchase', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'itemIssued', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('modules')->insert($modules);
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
