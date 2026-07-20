<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $secretary = Role::firstOrCreate(['name' => 'secretary', 'guard_name' => 'web']);
        $committeeHead = Role::firstOrCreate(['name' => 'committee_head', 'guard_name' => 'web']);
        $member = Role::firstOrCreate(['name' => 'member', 'guard_name' => 'web']);

        $allPermissions = Permission::all();
        $superAdmin->syncPermissions($allPermissions);

        $adminPermissions = ['manage-users', 'manage-meetings', 'manage-minutes', 'manage-committees', 'manage-attendance', 'send-memo', 'view-reports', 'manage-roles'];
        $admin->syncPermissions($adminPermissions);

        $secretaryPermissions = ['manage-meetings', 'manage-minutes', 'manage-attendance', 'send-memo', 'view-reports'];
        $secretary->syncPermissions($secretaryPermissions);

        $committeeHeadPermissions = ['manage-meetings', 'manage-attendance', 'send-memo', 'view-reports'];
        $committeeHead->syncPermissions($committeeHeadPermissions);

        $memberPermissions = ['view-reports'];
        $member->syncPermissions($memberPermissions);
    }
}
