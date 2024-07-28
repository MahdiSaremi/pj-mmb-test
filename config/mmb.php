<?php

use App\Mmb\Handlers;
use Mmb\Core;

return [

    /*
    |--------------------------------------------------------------------------
    | Robot channeling
    |--------------------------------------------------------------------------
    |
    | Channeling is how api works with telegram requests.
    | You can use Core\DefaultBotChanneling for multiple robots using constant config.
    | Or use Core\CreativeBotChanneling for multiple robots using database.
    |
    */

    'channeling'     => Core\DefaultBotChanneling::class,

    'channels'       => [
        'default' => [
            'token'     => env('BOT_TOKEN'),
            'username'  => env('BOT_USERNAME'),
            'hookToken' => md5(env('BOT_TOKEN') . env('APP_KEY')),
            // 'guard'     => 'bot',

            'handlers' => [
                Handlers\PrivateHandler::class,
            ],
        ],
    ],

    'default_guard' => env('MMB_GUARD', 'bot'),



    /*
    |--------------------------------------------------------------------------
    | Areas
    |--------------------------------------------------------------------------
    |
    | Define all Area classes to booting in start.
    |
    */

    'areas' => [
        \App\Mmb\Areas\GlobalArea::class,
        \App\Mmb\Admin\Areas\AdminArea::class,
    ],

];
