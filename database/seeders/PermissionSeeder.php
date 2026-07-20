<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'manage-users', 'guard_name' => 'web', 'category' => 'User Management'],
            ['name' => 'manage-meetings', 'guard_name' => 'web', 'category' => 'Meeting Management'],
            ['name' => 'manage-minutes', 'guard_name' => 'web', 'category' => 'Meeting Management'],
            ['name' => 'manage-committees', 'guard_name' => 'web', 'category' => 'Committee Management'],
            ['name' => 'manage-attendance', 'guard_name' => 'web', 'category' => 'Attendance'],
            ['name' => 'send-memo', 'guard_name' => 'web', 'category' => 'Communications'],
            ['name' => 'view-reports', 'guard_name' => 'web', 'category' => 'Reports'],
            ['name' => 'manage-roles', 'guard_name' => 'web', 'category' => 'System'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name'], 'guard_name' => $permission['guard_name']],
                ['category' => $permission['category']]
            );
        }
    }
}
