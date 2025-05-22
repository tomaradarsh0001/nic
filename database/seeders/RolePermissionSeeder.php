<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            1 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
        ];

        foreach ($permissions as $role_id => $role_permissions) {
            foreach ($role_permissions as $permission_id) {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $permission_id,
                    'role_id' => $role_id
                ]);
            }
        }
    }
}
