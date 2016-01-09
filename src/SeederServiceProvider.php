<?php

namespace Styde\Seeder;

use Illuminate\Support\ServiceProvider;

class SeederServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(SeederMakeCommand::class);
    }

}