<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $guard = config('roles.guard_name', 'bot');

        foreach (config('roles.permissions', []) as $permission) {
            Permission::findOrCreate($permission, $guard);
        }

        foreach (config('roles.roles', []) as $role => $permissions) {
            $permissions = $permissions == '*' ? config('roles.permissions') : (array)$permissions;

            Role::findOrCreate($role, $guard)->syncPermissions($permissions);
        }
    }
}
