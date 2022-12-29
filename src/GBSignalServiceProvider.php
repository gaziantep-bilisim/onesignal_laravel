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


        if($this->app->runningInConsole()){

            // if( !class_exists('GbsignalNotifications') ){
            //     $this->publishes([
            //         __DIR__.'/database/Migrations/gbsignal_notification_jobs.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_gbsignal_notification_jobs.php'),
            //         __DIR__.'/database/Migrations/gbsignal_notifications.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_gbsignal_notifications.php'),
            //     ], 'migrations');
            // }

            $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations/');

            $this->publishes([
                __DIR__ . '/Config/gbsignal.php' => config_path('gbsignal.php'),
            ]);

            $this->mergeConfigFrom(
                __DIR__ . '/Config/gbsignal.php', 'gbsignal'
            );

        }



        // $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations/');
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
