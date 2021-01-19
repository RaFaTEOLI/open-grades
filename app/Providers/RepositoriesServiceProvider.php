<?php

namespace App\Providers;

use App\Repositories\TelegramRepository;
use App\Repositories\TelegramRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(TelegramRepositoryInterface::class, TelegramRepository::class);
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
        $this->app->bind(TelegramRepositoryInterface::class, TelegramRepository::class);
    }
}
