<?php

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Support\Str;
use Juzaweb\CMS\Support\Config\GenerateConfigReader;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Support\Stub;
use Juzaweb\CMS\Traits\ModuleCommandTrait;
use Juzaweb\DevTool\Abstracts\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class RepositoryMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected string $argumentName = 'repository';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful repository for the specified plugin.';

    protected function afterHandle(): void
    {
        $path = str_replace('\\', '/', $this->getDestinationFileEloquentPath());

        $contents = (new Stub('/repository/repository_eloquent.stub', $this->getDataStub()))->render();

        $this->makeFile($path, $contents);
    }

    /**
     * Get repository name.
     *
     * @return string
     */
    public function getDestinationFileEloquentPath(): string
    {
        $path = $this->laravel['plugins']->getModulePath($this->getModuleName());

        $repositoryPath = GenerateConfigReader::read('repository');

        return $path . $repositoryPath->getPath() . '/' . $this->getRepositoryName() . 'Eloquent.php';
    }

    /**
     * Get repository name.
     *
     * @return string
     */
    public function getDestinationFilePath(): string
    {
        $path = $this->laravel['plugins']->getModulePath($this->getModuleName());

        $repositoryPath = GenerateConfigReader::read('repository');

        return $path . $repositoryPath->getPath() . '/' . $this->getRepositoryName() . '.php';
    }

    /**
     * @return array|string
     */
    protected function getRepositoryName(): array|string
    {
        $repository = $this->getModelName();

        if (Str::contains(strtolower($repository), 'repository') === false) {
            $repository .= 'Repository';
        }

        return $repository;
    }

    protected function getModelName(): string
    {
        return Str::studly($this->argument('repository'));
    }

    public function getDefaultNamespace(): string
    {
        return 'Repositories';
    }

    /**
     * @return string
     */
    protected function getTemplateContents(): string
    {
        return (new Stub($this->getStubName(), $this->getDataStub()))->render();
    }

    /**
     * Get the stub file name based on the options
     * @return string
     */
    protected function getStubName(): string
    {
        return '/repository/repository.stub';
    }

    protected function getDataStub(): array
    {
        /**
         * @var Plugin $module
         */
        $module = $this->laravel['plugins']->findOrFail($this->getModuleName());

        return [
            'MODULENAME' => $module->getStudlyName(),
            'CONTROLLERNAME' => $this->getRepositoryName(),
            'NAMESPACE' => $module->getStudlyName(),
            'DOMAIN_NAME' => $module->getDomainName(),
            'CLASS_NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getRepositoryNameWithoutNamespace(),
            'LOWER_NAME' => $module->getLowerName(),
            'SNAKE_NAME' => $module->getSnakeName(),
            'MODULE' => $this->getModuleName(),
            'NAME' => $this->getModuleName(),
            'STUDLY_NAME' => $module->getStudlyName(),
            'MODULE_NAMESPACE' => $this->getModuleNamespace($module),
            'MODEL_NAME' => $this->argument('repository'),
        ];
    }

    /**
     * @return array|string
     */
    protected function getRepositoryNameWithoutNamespace(): array|string
    {
        return class_basename($this->getRepositoryName());
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['repository', InputArgument::REQUIRED, 'The name of the repository class.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            //['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain repository', null],
            //['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the repository.'],
        ];
    }
}
