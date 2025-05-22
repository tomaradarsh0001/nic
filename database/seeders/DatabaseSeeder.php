<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // RoleSeeder::class,
            // PermissionSeeder::class,
            // RolePermissionSeeder::class,
            // UserSeeder::class
            // ModulesTableSeeder::class,
            // DesignationSeeder::class,
            // SectionSeeder::class,
            // ConfigurationSeeder::class,
            // MessageTemplateSeeder::class,

            /**Seeders added by Nitin */
            // ConversionChargesSeeder::class,
            // ConversionPermissionSeeder::class,
            // LandUSeChangeMatrixSeeder::class,
            // LandUseChangeCalculationPermissionSeeder::class,
            //GroupItemSeeder::class,
            // ActivateApplicantType::class,
            // CountriesSeeder::class,
            // StatesTableSeeder::class,
            // CitiesTableSeeder::class,
            // CitiesTableChunkTwoSeeder::class,
            // CitiesTableChunkThreeSeeder::class,
            // CitiesTableChunkFourSeeder::class,
            // CitiesTableChunkFiveSeeder::class,
            // UpdateOldColoniesSeeder::class
            
        ]);
    }
}
