<?php

namespace Juzaweb\Console\Commands\Plugin;

use Illuminate\Support\Str;
use Juzaweb\Support\Config\GenerateConfigReader;
use Juzaweb\Support\Stub;
use Juzaweb\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'controller';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful controller for the specified plugin.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['plugins']->getModulePath($this->getModuleName());

        $controllerPath = GenerateConfigReader::read('controller');

        return $path . $controllerPath->getPath() . '/' . $this->getControllerName() . '.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        return (new Stub($this->getStubName(), $this->getDataStub()))->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['controller', InputArgument::REQUIRED, 'The name of the controller class.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain controller', null],
            ['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the controller.'],
        ];
    }

    /**
     * @return array|string
     */
    protected function getControllerName()
    {
        $controller = Str::studly($this->argument('controller'));

        if (Str::contains(strtolower($controller), 'controller') === false) {
            $controller .= 'Controller';
        }

        return $controller;
    }

    /**
     * @return array|string
     */
    private function getControllerNameWithoutNamespace()
    {
        return class_basename($this->getControllerName());
    }

    public function getDefaultNamespace(): string
    {
        return 'Http/Controllers';
    }

    /**
     * Get the stub file name based on the options
     * @return string
     */
    protected function getStubName()
    {
        if ($this->option('plain') === true) {
            $stub = '/controller-plain.stub';
        } elseif ($this->option('api') === true) {
            $stub = '/controller-api.stub';
        } else {
            $stub = '/controller.stub';
        }

        return $stub;
    }

    protected function getDataStub()
    {
        /**
         * @var \Juzaweb\Abstracts\Plugin $module
         */
        $module = $this->laravel['plugins']->findOrFail($this->getModuleName());

        return [
            'MODULENAME' => $module->getStudlyName(),
            'CONTROLLERNAME' => $this->getControllerName(),
            'NAMESPACE' => $module->getStudlyName(),
            'DOMAIN_NAME' => $module->getDomainName(),
            'CLASS_NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getControllerNameWithoutNamespace(),
            'LOWER_NAME' => $module->getLowerName(),
            'SNAKE_NAME' => $module->getSnakeName(),
            'MODULE' => $this->getModuleName(),
            'NAME' => $this->getModuleName(),
            'STUDLY_NAME' => $module->getStudlyName(),
            'MODULE_NAMESPACE' => $this->laravel['plugins']->config('namespace'),
        ];
    }
}
