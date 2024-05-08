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
        $stubsDirectory = __DIR__.'/../stubs';

        //$this->publishes([$viewsDirectory => base_path('resources/views/vendor/'.$this->pluginName)], 'views');
        //$this->publishes([ $publishAssetsDirectory => public_path('vendor/'.$this->pluginName) ], 'public');

    }

    private function registerConsoleCommands()
    {
        $this->commands(Commands\ScaffoldGeneratorCommand::class);
    }
}
