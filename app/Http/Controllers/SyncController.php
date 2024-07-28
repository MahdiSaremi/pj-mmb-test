<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mmb\Core\Bot;

class SyncController extends Controller
{

    public function __invoke()
    {
        $bot = app(Bot::class);

        $bot->setMyWebhook();
    }

}
