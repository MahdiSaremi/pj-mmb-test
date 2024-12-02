<?php

namespace App\Mmb\Handlers;

use Mmb\Action\Update\UpdateHandler;

class InlineQueryHandler extends UpdateHandler
{

    public function handle(HandlerFactory $handler)
    {
        $handler
            ->match($this->update->inlineQuery)
            ->recordUser(
                BotUser::class,
                $this->update->getUser()?->id,
                validate: $this->validateUser(...),
                autoSave: true,
            )
            ->handle([
                $handler->inherit(),
            ])
        ;
    }

    public function validateUser(BotUser $user)
    {
        // return $user->ban === false || $user->can('IgnoreBan');
        return true;
    }

}
