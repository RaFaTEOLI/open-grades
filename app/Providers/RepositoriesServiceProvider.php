<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\Util\ConfigurationInterface;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(InvitationLinkInterface::class, InvitationLinkRepository::class);
        $this->app->bind(ConfigurationRepositoryInterface::class, ConfigurationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(InvitationLinkInterface::class, InvitationLinkRepository::class);
        $this->app->bind(ConfigurationRepositoryInterface::class, ConfigurationRepository::class);
    }
}
