<?php

use App\Models\BotUser;
use Modules\Home\Mmb\Sections\HomeSection;
use Modules\Panel\Mmb\Sections\PanelSection;

return [

    /*
    |--------------------------------------------------------------------------
    | User Model Class
    |--------------------------------------------------------------------------
    |
    | User class helps the application to work with user data
    |
    */
    'user' => BotUser::class,

    /*
    |--------------------------------------------------------------------------
    | Lock Service Configs
    |--------------------------------------------------------------------------
    |
    | Lock service helps you to manage locking system, like joining to channels
    |
    */
    'lock' => [
        'groups' => [
            'main' => 'panelkit::lock.groups.main',
        ],
        'condition' => null,
        'fixed' => [
            [
                'chat_id' => -123455678,
                'title' => 'Join',
                'url' => 'https://t.me/Link',
                'group' => 'main',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Back Actions
    |--------------------------------------------------------------------------
    |
    | When a user or admin clicked on "Back" button, what methods should
    | be run?
    |
    */
    'back' => [
        'user'  => [
            '*' => [HomeSection::class, 'main'],
        ],
        'admin' => [
            '*' => [PanelSection::class, 'main'],
        ],
    ],

];
