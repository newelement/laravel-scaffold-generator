<?php

namespace Newelement\LaravelScaffoldGenerator;

use Illuminate\Support\ServiceProvider;

class LaravelScaffoldGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConsoleCommands();
    }

    public function boot()
    {
        //$stubsDirectory = __DIR__.'/../stubs';
    }

    private function registerConsoleCommands()
    {
        $this->commands(Commands\ScaffoldGeneratorCommand::class);
    }
}
