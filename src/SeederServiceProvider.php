<?php

namespace Styde\Seeder;

use Illuminate\Support\ServiceProvider;

class SeederServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.seeder.make', function ($app) {
            return new SeederMakeCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.seeder.make'];
    }

}