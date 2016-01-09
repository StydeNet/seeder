<?php

namespace Styde\Seeder;

class SeederMakeCommand extends \Illuminate\Database\Console\Seeds\SeederMakeCommand
{

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/seeder.stub';
    }

}