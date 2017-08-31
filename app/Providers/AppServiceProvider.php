<?php

namespace App\Providers;

use App\Library\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $routes = $this->app['router']->getRoutes();

        //Replace UrlGenerator with CustomUrlGenerator
        $customUrlGenerator = new UrlGenerator($routes, $this->app->make('request'));
        $this->app->instance('url', $customUrlGenerator);
    }
}
