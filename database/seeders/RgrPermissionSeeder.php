<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RgrPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'create.rgr']);
        Permission::create(['name' => 'create.rgr.draft']);
        Permission::create(['name' => 'send.rgr.draft']);
        Permission::create(['name' => 'view.rgr.list']);
        $role = Role::where('name', 'super-admin')->first();
        $role->givePermissionTo(['create.rgr', 'create.rgr.draft', 'send.rgr.draft', 'view.rgr.list']);
    }
}
