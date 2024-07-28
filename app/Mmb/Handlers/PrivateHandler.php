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

    protected bool $isBusy = false;

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
            ->invoke(fn (BotUser $record) => ModelFinder::storeCurrent($record->account))
            ->invoke(fn (BotUser $record) => $this->isBusy = $record->isBusy())
            ->handle([
                when(!$this->isBusy, [

                    // \Modules\Home\Mmb\Commands\StartCommand::class,
                    Commands\UserCommand::class,
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
                ]),

                $handler->inherit('force'),

                $handler->step(),
            ])
            ->invoke($this->updateOnline(...))
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

    public function updateOnline(BotUser $record)
    {
        if (!$record->account->was_online)
        {
            event(new AccountIsOnline($record->account));
        }

        $record->account->update([
            'last_online_at' => now(),
        ]);
    }

}
