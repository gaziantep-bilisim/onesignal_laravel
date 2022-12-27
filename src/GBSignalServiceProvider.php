<?php

namespace HumblDump\GBSignal;

use Illuminate\Support\ServiceProvider;

class GBSignalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/GBSignal.php' => config_path('GBSignal.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/Config/GBSignal.php', 'GBSignal'
        );

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations/');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('GBSignal', function ($app) {
            return new GBSignal();
        });
    }

    /**
     * It returns an array of the service names that the service provider registers.
     *
     * @return The service provider class name.
     */
    public function provides()
    {
        return ['GBSignal'];
    }
}
