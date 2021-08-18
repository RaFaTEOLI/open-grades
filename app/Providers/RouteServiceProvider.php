<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = "App\Http\Controllers";

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware("web")
            ->namespace($this->namespace)
            ->group(base_path("routes/web/web.php"));

        $this->loadWebRoute("user");
        $this->loadWebRoute("role");
        $this->loadWebRoute("invitation");
        $this->loadWebRoute("configuration");
        $this->loadWebRoute("permission");
        $this->loadWebRoute("student");
        $this->loadWebRoute("teacher");
        $this->loadWebRoute("subject");
        $this->loadWebRoute("year");
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix("api")
            ->middleware("api")
            ->namespace($this->namespace)
            ->group(base_path("routes/api/api.php"));

        $this->loadApiRoute("user");
        $this->loadApiRoute("role");
        $this->loadApiRoute("invitation");
        $this->loadApiRoute("configuration");
        $this->loadApiRoute("telegram");
        $this->loadApiRoute("permission");
        $this->loadApiRoute("student");
        $this->loadApiRoute("teacher");
        $this->loadApiRoute("subject");
        $this->loadApiRoute("year");
    }

    private function loadWebRoute($routeName)
    {
        Route::middleware("web")
            ->namespace($this->namespace)
            ->group(base_path("routes/web/{$routeName}.php"));
    }

    private function loadApiRoute($routeName)
    {
        Route::prefix("api")
            ->middleware("api")
            ->namespace($this->namespace)
            ->group(base_path("routes/api/{$routeName}.php"));
    }
}
