<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sections')->truncate();
        $sections = [
            ['section_code' => 'LDO', 'name' => 'Land and Development Office', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LDOPS', 'name' => 'L&amp;DO Personnal Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'DYLDO1', 'name' => 'Deputy L&amp;DO-I', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'DYLDO2', 'name' => 'Deputy L&amp;DO-II', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'DYLDO3', 'name' => 'Deputy L&amp;DO-III', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'DYLDO4', 'name' => 'Deputy L&amp;DO-IV', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'DYLDO5', 'name' => 'Deputy L&amp;DO-V', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'DYLDO6', 'name' => 'Deputy L&amp;DO-VI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'DYLDO7', 'name' => 'Deputy L&amp;DO-VII', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'ADMN', 'name' => 'Administration Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PERS', 'name' => 'Personal Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'VIG', 'name' => 'Vigilance Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PLCY', 'name' => 'Policy Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'CDN', 'name' => 'Coordination Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'REC', 'name' => 'Record Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LIT', 'name' => 'Litigation Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'ENF', 'name' => 'Enforcement Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'HPIL', 'name' => 'HPIL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'HINDI', 'name' => 'Hindi Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'DESP', 'name' => 'Dispatch Section', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PRO', 'name' => 'Public Relation Officer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'CCELL', 'name' => 'Conveyance Cell', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PCELL', 'name' => 'Project Cell', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PGCEL', 'name' => 'Public Grievances Cell', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LEG', 'name' => 'Legal Cell', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'RPC', 'name' => 'R P Cell', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'ESO', 'name' => 'Estate Officer Court', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'ESO1', 'name' => 'Estate Officer Court-I', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'ESO2', 'name' => 'Estate Officer Court-II', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LS1', 'name' => 'Lease Section-I', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LS2A', 'name' => 'Lease Section-II A', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LS2B', 'name' => 'Lease Section-II B', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LS3', 'name' => 'Lease Section-III', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LS4', 'name' => 'Lease Section-IV', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LS5', 'name' => 'Lease Section-V', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LS5A', 'name' => 'Lease Section-V A', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'LS5B', 'name' => 'Lease Section-V B', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PS1', 'name' => 'Property Section-I', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PS2', 'name' => 'Property Section-II', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PS3', 'name' => 'Property Section-III', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'PS4', 'name' => 'Property Section-IV', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['section_code' => 'IFC', 'name' => 'Information Facilitation Centre', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('sections')->insert($sections);
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
