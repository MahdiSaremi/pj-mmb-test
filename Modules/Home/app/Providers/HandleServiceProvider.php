<?php

namespace Modules\Home\Providers;

use App\Mmb\Handlers\PrivateHandler;
use Mmb\Action\Update\HandlerExtends;
use Mmb\Action\Update\HandlerFactory;
use Mmb\Support\Providers\HandleServiceProvider as ServiceProvider;
use Modules\Home\Mmb\Commands\StartCommand;

class HandleServiceProvider extends ServiceProvider
{

    /**
     * List of the handlers
     */
    protected array $handlers = [];

    /**
     * Map of extended handler and callback method name
     */
    protected array $extend = [
        PrivateHandler::class => 'extendPrivate',
    ];

    public function extendPrivate(HandlerExtends $extends)
    {
        $extends->handle(fn (HandlerFactory $handler) => [
            StartCommand::class,
        ], 'commands');

        // $extends->handle(fn (HandlerFactory $handler) => [
        //     $handler->callback(
        //         //
        //     )
        // ]);
    }

}
