<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate([
            'name' => 'System Admin',
            'created_by' => 1,
            'deletable' => false,
        ]);
        $permissions = Permission::pluck('id');
        $role->permissions()->sync($permissions);
    }
}
