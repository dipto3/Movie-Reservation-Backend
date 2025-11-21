<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role Manage
        $rolesManage = PermissionGroup::updateOrCreate([
            'name' => 'Roles Manage',
        ]);
        Permission::updateOrCreate([
            'permission_group_id' => $rolesManage->id,
            'name' => 'Access Roles',
            'slug' => 'role.access',
        ]);
        Permission::updateOrCreate([
            'permission_group_id' => $rolesManage->id,
            'name' => 'Create Roles',
            'slug' => 'role.create',
        ]);
        Permission::updateOrCreate([
            'permission_group_id' => $rolesManage->id,
            'name' => 'Edit Roles',
            'slug' => 'role.edit',
        ]);
        Permission::updateOrCreate([
            'permission_group_id' => $rolesManage->id,
            'name' => 'Destroy Roles',
            'slug' => 'role.destroy',
        ]);
    }
}
