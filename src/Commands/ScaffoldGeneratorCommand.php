<?php

namespace Newelement\LaravelScaffoldGenerator\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputArgument;

class ScaffoldGeneratorCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:scaffold 
                        {name : The class prefix name for the file(s) to be generated} 
                        {--a : Create all the files. Service, Model, Migration, Controller, Resource}
                        {--service : Create service class}
                        {--model : Create model class}
                        {--model-migration : Create model and migration}
                        {--controller : Create controller class
                        {--resource : Create Request class}
                        {--request : Create Resource class}
                        {--rcs : Create Request, Controller, Service}
                        {--rcsr : Create Request, Controller, Service, Resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates files for dev design pattern.';


    public function handle()
    {
        $name = ucwords($this->argument('name'));
        $all = $this->option('a');
        $service = $this->option('service');
        $model = $this->option('model');
        $modelMigration = $this->option('model-migration');
        $controller = $this->option('controller');
        $resource = $this->option('resource');
        $request = $this->option('request');
        $rcs = $this->option('rcs');
        $rcsr = $this->option('rcsr');

        Artisan::call('make:model', ['name' => $this->argument('name')]);

        return parent::handle();
    }

    protected function getStub(): string
    {
        return __DIR__ . '/../../stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace = 'App'): string
    {
        return $rootNamespace.'\Services';
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the service'],
        ];
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in the base namespace.
     *
     * @param  string  $name
     *
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string
    {
        return parent::buildClass($name);
    }
}
