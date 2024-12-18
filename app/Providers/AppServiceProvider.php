<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mmb\Core\Requests\TelegramRequest;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (config('app.host_mode'))
            $this->app->usePublicPath(realpath(base_path().'/../public_html'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.enable_proxy'))
            TelegramRequest::appendOptions([
                'proxy' => config('app.proxy'),
            ]);
    }
}
