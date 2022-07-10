<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Commands\Resource;

use Illuminate\Support\Str;
use Juzaweb\CMS\Support\Config\GenerateConfigReader;
use Juzaweb\CMS\Support\Stub;
use Juzaweb\CMS\Traits\ModuleCommandTrait;
use Juzaweb\DevTool\Commands\Plugin\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DatatableMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-datatable';

    protected $argumentName = 'name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful datatable for the specified plugin.';

    public function getDefaultNamespace(): string
    {
        return 'Http/Datatables';
    }

    /**
     * Get template contents.
     *
     * @return string
     */
    protected function getTemplateContents()
    {
        return (new Stub('/resource/datatable.stub', $this->getDataStub()))->render();
    }

    protected function getDataStub()
    {
        /**
         * @var \Juzaweb\CMS\Support\Plugin $module
         */
        $module = $this->laravel['plugins']->findOrFail($this->getModuleName());

        return array_merge(
            [
                'MODULENAME' => $module->getStudlyName(),
                'NAMESPACE' => $module->getStudlyName(),
                'DOMAIN_NAME' => $module->getDomainName(),
                'CLASS_NAMESPACE' => $this->getClassNamespace($module),
                'CLASS' => $this->getDatatableNameWithoutNamespace(),
                'LOWER_NAME' => $module->getLowerName(),
                'SNAKE_NAME' => $module->getSnakeName(),
                'MODULE' => $this->getModuleName(),
                'NAME' => $this->getModuleName(),
                'STUDLY_NAME' => $module->getStudlyName(),
                'MODULE_NAMESPACE' => $this->laravel['plugins']->config('namespace'),
            ],
            $this->getDataModelStub()
        );
    }

    /**
     * @return array|string
     */
    protected function getDatatableNameWithoutNamespace()
    {
        return class_basename($this->getDatatableName());
    }

    /**
     * @return array|string
     */
    protected function getDatatableName()
    {
        $name = Str::studly($this->argument('name'));

        if (Str::contains(strtolower($name), 'datatable') === false) {
            $name .= 'Datatable';
        }

        return $name;
    }

    protected function getDataModelStub()
    {
        $data = [
            'QUERY_TABLE' => '// Query handle',
            'USE_NAMESPACE' => '',
            'COLUMNS' => '',
            'BULK_ACTIONS' => 'switch ($action) {
            case \'delete\':

                break;
        }',
        ];

        if ($model = $this->option('model')) {
            $module = $this->laravel['plugins']->findOrFail($this->getModuleName());

            $data['QUERY_TABLE'] = $this->stubRender(
                'resource/datatable/query-model.stub',
                [
                    'MODEL_NAME' => $model,
                ]
            );

            $data['USE_NAMESPACE'] = $this->stubRender(
                'resource/datatable/use-namespaces.stub',
                [
                    'NAMESPACE' => str_replace('/', '\\', $module->getStudlyName()) . '\Models\\' . $model . ";\n",
                ]
            );

            $data['BULK_ACTIONS'] = $this->stubRender(
                'resource/datatable/bulk-actions.stub',
                [
                    'MODEL_NAME' => $model,
                ]
            );

            $data['COLUMNS'] = $this->getDataColumns($module);
        }

        return $data;
    }

    protected function getDataColumns($module)
    {
        $result = '';
        $columns = explode(',', $this->option('columns'));
        $columns = collect($columns)
            ->filter(
                function ($item) {
                    return ! in_array(
                        $item,
                        [
                            'description',
                            'content',
                        ]
                    );
                }
            )->toArray();

        foreach ($columns as $key => $column) {
            if (in_array($column, ['name', 'title', 'subject'])) {
                $result = $this->stubRender(
                    'resource/datatable/action-column.stub',
                    [
                    'MODULE_DOMAIN' => $module->getDomainName(),
                    'COLUMN' => $column,
                    ]
                );

                unset($columns[$key]);
            }
        }

        if (empty($result)) {
            $result = '// \'title\' => [
            //     \'label\' => trans(\'cms::app.title\'),
            //     \'formatter\' => [$this, \'rowActionsFormatter\'],
            // ],';
        }

        foreach ($columns as $column) {
            $result .= "\n\t\t\t" . $this->stubRender(
                $this->getColumnStubPath($column),
                [
                    'MODULE_DOMAIN' => $module->getDomainName(),
                    'COLUMN' => $column,
                ]
            );
        }

        return $result;
    }

    protected function getColumnStubPath($column)
    {
        $stubPath = JW_PACKAGE_PATH . '/stubs/plugin/';
        $columnStub = 'resource/datatable/columns/' . $column . '.stub';

        if (file_exists($stubPath . '/' . $columnStub)) {
            return $columnStub;
        }

        return 'resource/datatable/default-column.stub';
    }

    /**
     * Get the destination file path.
     *
     * @return string
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['plugins']->getModulePath($this->getModuleName());
        $datatablePath = GenerateConfigReader::read('datatable');

        return $path . $datatablePath->getPath() . '/' . $this->getDatatableName() . '.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the datatable class.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The model for query.', null],
            ['columns', null, InputOption::VALUE_OPTIONAL, 'The columns for table.', null],
        ];
    }
}
