<?php

namespace Styde\Seeder;

class SeederMakeCommand extends \Illuminate\Database\Console\Seeds\SeederMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'styde:seeder';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/seeder.stub';
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function parseName($name)
    {
        return Helper::$prefix.$name.Helper::$suffix;
    }

}