<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mmb\Core\Client\TelegramClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (config('app.host_mode'))
            $this->app->usePublicPath(realpath(base_path() . '/../public_html'));

        $this->registerRoles();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.enable_proxy'))
            TelegramClient::appendOptions([
                'proxy' => config('app.proxy'),
            ]);
    }

    /**
     * Register roles & permissions
     */
    public function registerRoles()
    {
        Gate::before(function ($user, $ability) {
            if ($roles = @config('roles.const', [])[get_class($user)][$user?->getKey()]) {
                foreach ((array)$roles as $role) {
                    if ($permissions = @config('roles.roles', [])[$role]) {
                        $permissions = $permissions == '*' ? config('roles.permissions') : (array)$permissions;
                        if (in_array($ability, $permissions)) {
                            return true;
                        }
                    }
                }
            }

            return null;
        });
    }
}
