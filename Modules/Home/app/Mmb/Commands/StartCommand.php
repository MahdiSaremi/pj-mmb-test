<?php

namespace Modules\Home\Mmb\Commands;

use App\Models\User;
use Modules\Home\Mmb\Sections\HomeSection;
use App\Models\BotUser;
use Mmb\Action\Event\StartCommandAction;

class StartCommand extends StartCommandAction
{

    protected $command = ['/start', '/start {code:any?}' => 'invited'];

    protected $ignoreSpaces = true;

    public function handle()
    {
        HomeSection::make()->main();
    }

    public function invited(string $code)
    {
        // if (
        //     BotUser::current()->wasRecentlyCreated &&
        //     $invitedBy = BotUser::query()->where('invite_code', $code)->first()
        // )
        // {
        //     InviteService::make()->newUser(BotUser::current(), $invitedBy);
        // }

        $this->handle();
    }

}
