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
    protected $signature = 'make:scaffold
                        {name : The class prefix name for the file(s) to be generated. Without Service/Controller suffix.}
                        {--a : Create all the files. Service, Model, Migration, Controller, Resource}
                        {--service : Create service class}
                        {--model : Create model class}
                        {--model-migration : Create model and migration}
                        {--controller : Create controller class}
                        {--resource : Create Resource class}
                        {--request : Create Request class}
                        {--rcs : Create Request, Controller, Service}
                        {--rcsr : Create Request, Controller, Service, Resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates files for dev design pattern.';

    protected $name;
    protected $service;
    protected $model;
    protected $modelMigration;
    protected $controller;
    protected $resource;
    protected $request;
    protected $all;
    protected $rcs;
    protected $rcsr;

    public function handle()
    {
        $this->name = ucwords($this->argument('name'));
        $this->all = $this->option('a');
        $this->service = $this->option('service');
        $this->model = $this->option('model');
        $this->modelMigration = $this->option('model-migration');
        $this->controller = $this->option('controller');
        $this->resource = $this->option('resource');
        $this->request = $this->option('request');
        $this->rcs = $this->option('rcs');
        $this->rcsr = $this->option('rcsr');

        if($this->all || $this->model || $this->modelMigration) {
            $this->makeModel();
        }

        if($this->all || $this->controller) {
            $this->makeController();
        }

        if($this->all || $this->request) {
            $this->makeRequest();
        }

        if($this->all || $this->resource) {
            $this->makeResource();
        }

        if($this->rcs) {
            $this->makeRequest();
            $this->makeController();
        }

        if($this->rcsr) {
            $this->makeRequest();
            $this->makeController();
            $this->makeResource();
        }

        return parent::handle();
    }

    /**
     * Make model
     *
     * @return void
     */
    protected function makeModel(): void
    {
        $args = ['name' => $this->name];
        if($this->modelMigration) {
            $args['-m'] = true;
        }
        Artisan::call('make:model', $args);
        $this->components->info($args['name'].' model created.');
    }

    /**
     * Make controller
     *
     * @return void
     */
    protected function makeController(): void
    {
        $args = ['name' => $this->name.'Controller'];
        Artisan::call('make:controller', $args);
        $this->components->info($args['name'].' created.');
    }

    /**
     * Make request
     *
     * @return void
     */
    protected function makeRequest(): void
    {
        $args = ['name' => $this->name.'Request'];
        Artisan::call('make:request', $args);
        $this->components->info($args['name'].' created.');
    }

    /**
     * Make resource
     *
     * @return void
     */
    protected function makeResource(): void
    {
        $args = ['name' => $this->name.'Resource'];
        Artisan::call('make:resource', $args);
        $this->components->info($args['name'].' created.');
    }

    /**
     * Get stub file path
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../../stubs/service.stub';
    }

    /**
     * Get the default namespace for the service class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace = 'App'): string
    {
        return $rootNamespace.'\Services';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the service'],
        ];
    }

    /**
     * Get the name of the class
     *
     * @return string
     */
    protected function getNameInput(): string
    {
        return $this->argument('name').'Service';
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
    protected function buildClass($name): mixed
    {
        if($this->service || $this->all || $this->rcs || $this->rcsr) {
            return parent::buildClass($name);
        }
    }
}
