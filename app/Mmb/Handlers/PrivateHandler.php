<?php

namespace App\Mmb\Handlers;

use App\Mmb\Admin\Commands\ChatPageCommand;
use App\Mmb\Admin\Commands\ShowContentCommand;
use App\Mmb\Main\Commands;
use App\Models\BotUser;
use Mmb\Action\Update\HandlerFactory;
use Mmb\Action\Update\UpdateHandler;
use Mmb\Support\Db\ModelFinder;
use Modules\Account\Events\AccountIsOnline;
use Rapid\Mmb\PanelKit\Lock\LockRequest;

class PrivateHandler extends UpdateHandler
{

    public function handle(HandlerFactory $handler)
    {
        $handler
            ->match($this->update->getChat()?->type == 'private')
            ->recordUser(
                BotUser::class,
                $this->update->getUser()?->id,
                create: $this->createUser(...),
                validate: $this->validateUser(...),
                autoSave: true,
            )
            ->handle([

                // \Modules\Home\Mmb\Commands\StartCommand::class,
                $handler->inherit('commands'),

                $handler->callback(LockRequest::class),
                LockRequest::for('main'),

                ChatPageCommand::class,
                ShowContentCommand::class,

                // GlobalDialogHandler::make(),

                // MiddleActions\RequirePhoneMiddleAction::class,
                // MiddleActions\RequireNameMiddleAction::class,

                // $handler->afterMiddles(Sections\Home\HomeSection::class, 'main'),

                $handler->inherit(),

                $handler->step(),
            ])
        ;
    }

    public function createUser()
    {
        $user = $this->update->getUser();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'step' => '',
        ];
    }

    public function validateUser(BotUser $user)
    {
        // return $user->ban === false || $user->can('IgnoreBan');
        return true;
    }

}
