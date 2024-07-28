<?php

namespace Database\Seeders;

use App\Models\BotUser;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public string $guardName = 'bot';

    public array $permissions = [
        'AccessPanel',
        'ModifyAdmins',
    ];

    public array $roles = [
        'SuperAdmin' => '*',
        'Admin' => ['AccessPanel'],
    ];

    public array $fixedUsers = [
        '370924007' => 'SuperAdmin',
    ];

    public function run(): void
    {
        foreach ($this->permissions as $permission)
        {
            Permission::findOrCreate($permission, $this->guardName);
        }

        foreach ($this->roles as $role => $permissions)
        {
            if ($permissions == '*') $permissions = $this->permissions;
            elseif (is_string($permissions)) $permissions = [$permissions];

            Role::findOrCreate($role, $this->guardName)->syncPermissions($permissions);
        }

        foreach ($this->fixedUsers as $user => $roles)
        {
            if ($roles === null) $roles = [];
            elseif (is_string($roles)) $roles = [$roles];

            BotUser::find($user)?->syncRoles($roles);
        }
    }
}
