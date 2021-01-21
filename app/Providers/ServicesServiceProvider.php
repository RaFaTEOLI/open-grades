<?php

namespace App\Providers;

use App\Services\CreateConfigurationService;
use App\Services\CreateInvitationLinkService;
use App\Services\CreateMessageService;
use App\Services\CreateUserService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CreateUserService::class);
        $this->app->bind(CreateConfigurationService::class);
        $this->app->bind(CreateInvitationLinkService::class);
        $this->app->bind(CreateMessageService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CreateUserService::class);
        $this->app->bind(CreateConfigurationService::class);
        $this->app->bind(CreateInvitationLinkService::class);
        $this->app->bind(CreateMessageService::class);
    }
}
