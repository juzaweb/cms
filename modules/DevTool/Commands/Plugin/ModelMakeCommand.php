<?php

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Support\Str;
use Juzaweb\CMS\Support\Config\GenerateConfigReader;
use Juzaweb\CMS\Support\Stub;
use Juzaweb\CMS\Traits\ModuleCommandTrait;
use Juzaweb\DevTool\Abstracts\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected string $argumentName = 'model';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model for the specified plugin.';

    public function handle(): void
    {
        parent::handle();

        $this->handleOptionalMigrationOption();
    }

    /**
     * Create the migration file with the given model if migration flag was used
     */
    private function handleOptionalMigrationOption(): void
    {
        if ($this->option('migration') === true) {
            $migrationName = 'create_'.$this->createMigrationName().'_table';
            $this->call('plugin:make-migration', ['name' => $migrationName, 'module' => $this->argument('module')]);
        }
    }

    /**
     * Create a proper migration name:
     * ProductDetail: product_details
     * Product: products
     * @return string
     */
    private function createMigrationName(): string
    {
        $pieces = preg_split('/(?=[A-Z])/', $this->argument('model'), -1, PREG_SPLIT_NO_EMPTY);

        $string = '';
        foreach ($pieces as $i => $piece) {
            if ($i + 1 < count($pieces)) {
                $string .= strtolower($piece).'_';
            } else {
                $string .= Str::plural(strtolower($piece));
            }
        }

        return $string;
    }

    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace(): string
    {
        return 'Models';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['model', InputArgument::REQUIRED, 'The name of model will be created.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['fillable', null, InputOption::VALUE_OPTIONAL, 'The fillable attributes.', null],
            ['migration', 'm', InputOption::VALUE_NONE, 'Flag to create associated migrations', null],
            ['stub', null, InputOption::VALUE_NONE, 'Stub path to create model', null],
            ['table', null, InputOption::VALUE_NONE, 'Table model', null],
        ];
    }

    /**
     * @return string
     * @throws \JsonException
     */
    protected function getTemplateContents(): string
    {
        $module = $this->laravel['plugins']->findOrFail($this->getModuleName());
        if (!$table = $this->option('table')) {
            $table = $module->getDomainName().'_'.$this->createMigrationName();
        }

        return (new Stub(
            $this->getStubPath(),
            [
                'NAME' => $this->getModelName(),
                'TABLE' => $table,
                'FILLABLE' => $this->getFillable(),
                'NAMESPACE' => $this->getClassNamespace($module),
                'CLASS' => $this->getClass(),
                'LOWER_NAME' => $module->getLowerName(),
                'MODULE' => $this->getModuleName(),
                'STUDLY_NAME' => $module->getStudlyName(),
                'MODULE_NAMESPACE' => $this->laravel['plugins']->config('namespace'),
            ]
        ))->render();
    }

    protected function getStubPath(): string
    {
        if ($stub = $this->option('stub')) {
            return '/'.$stub;
        }

        return '/model.stub';
    }

    /**
     * @return string
     */
    private function getModelName(): string
    {
        return Str::studly($this->argument('model'));
    }

    /**
     * @return string
     * @throws \JsonException
     */
    private function getFillable(): string
    {
        $fillable = $this->option('fillable');

        if (!is_null($fillable)) {
            $arrays = explode(',', $fillable);

            return Str::replace('"',  "'", json_encode($arrays, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
        }

        return '[]';
    }

    protected function getDestinationFilePath(): string
    {
        $path = $this->laravel['plugins']->getModulePath($this->getModuleName());

        $modelPath = GenerateConfigReader::read('model');

        return $path.$modelPath->getPath().'/'.$this->getModelName().'.php';
    }
}
