<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userSuperAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@yopmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $userSuperAdmin->syncRoles('super-admin');


       $userAdmin =  User::create([
            'name' => 'Admin',
            'email' => 'admin@yopmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $userAdmin->syncRoles('admin');


    }
}
