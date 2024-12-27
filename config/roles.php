<?php

use App\Models\BotUser;

return [

    /**
     * Name of the target guard
     */
    'guard_name' => 'bot',

    /**
     * List of permission names
     */
    'permissions' => [
        'access panel',
        'modify admins',
    ],

    /**
     * Map of roles and permissions
     *
     * Pass '*' to access all the permission from [permissions] values
     */
    'roles' => [
        'super admin' => '*',
        'admin' => ['access panel'],
    ],

    /**
     * Map of user id and the role(s)
     */
    'const' => [
        BotUser::class => [

            '370924007' => 'super admin',

        ],
    ],

];
