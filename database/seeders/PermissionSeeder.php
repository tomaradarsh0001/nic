<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view role',
            'create role',
            'update role',
            'delete role',
            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'view user',
            'create user',
            'update user',
            'delete user',
            'view dashboard',
            'view reports',
            'setting',
            'viewDetails',
            'edit.property.details',
            'create.demand',
            'club.membership',
            'club.membership.list',
            'club.membership.create',
            'club.membership.update',
            'club.membership.view',
            'club.membership.action',
            'index.application', //Create New Permission to show Main Application Menu to All Role - Lalit Tiwari (27/02/2025)
            'list.application', // Create New Permission for Received & Disposed Inner Sub Menu of Main Application Menu for Office User Role like Section & Deputy - Lalit Tiwari (27/02/2025)
            'miscellaneous', //Create New Permission miscellaneous for Miscellaneous - Lalit Tiwari (5/03/2025)
            'miscellaneous.property.transfer' // //Create New Permission for Property Transfer Submenu - Lalit Tiwari (5/03/2025)
        
        ];
        foreach ($permissions as $permission) {
            if (!(Permission::where('name', $permission)->exists())) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }
}