<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Abstracts\CRUD;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Juzaweb\CMS\Support\Config\GenerateConfigReader;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Traits\ModuleCommandTrait;

abstract class ResourceCommand extends Command
{
    use ModuleCommandTrait;

    /**
     * @var Plugin
     */
    protected Plugin $module;

    /**
     * @var array
     */
    protected array $columns;

    /**
     * Generates a model using the given table and model names.
     *
     * @param  string  $table  The name of the table to generate the model for.
     * @param  string  $model  The name of the model to generate.
     * @return void
     * @throws Exception If an error occurs during the model generation.
     */
    protected function makeModel(string $table, string $model): void
    {
        $this->call(
            'plugin:make-model',
            [
                'model' => $model,
                'module' => $this->getModuleName(),
                '--table' => $table,
                '--stub' => 'resource/model.stub',
                '--fillable' => implode(',', $this->columns),
            ]
        );
    }

    /**
     * Generates a data table for a given model.
     *
     * @param  string  $model  The name of the model.
     * @return void
     * @throws Exception If an error occurs while generating the data table.
     */
    protected function makeDataTable(string $model): void
    {
        $this->call(
            'plugin:make-datatable',
            [
                'name' => $model,
                'module' => $this->getModuleName(),
                '--repository' => "{$model}Repository",
                '--columns' => implode(',', $this->columns),
            ]
        );
    }

    /**
     * Generates the controller file for a given table and model.
     *
     * @param  string  $table  The name of the table.
     * @param  string  $model  The name of the model.
     * @return void
     * @throws Exception If an error occurs while generating the file.
     */
    protected function makeController(string $table, string $model): void
    {
        $file = $model.'Controller.php';
        $path = $this->getDestinationControllerFilePath($file);

        $contents = $this->stubRender(
            'resource/controller.stub',
            [
                'CLASS_NAMESPACE' => $this->module->getNamespace().'Http\Controllers\Backend',
                'DATATABLE' => $model.'Datatable',
                'MODEL_NAME' => $model,
                'MODULE_NAMESPACE' => $this->module->getNamespace(),
                'CLASS' => $model.'Controller',
                'TABLE_NAME' => $table,
                'VIEW_NAME' => Str::singular(Str::lower(Str::snake($model))),
                'MODULE_DOMAIN' => $this->module->getDomainName(),
            ]
        );

        $this->makeFile($path, $contents);
    }

    protected function makeRepository(string $model): void
    {
        $this->call(
            'plugin:make-repository',
            [
                'repository' => $model,
                'module' => $this->getModuleName(),
            ]
        );
    }

    /**
     * Generates views for a given table.
     *
     * @param  string  $table  The name of the table.
     * @return void
     */
    protected function makeViews(string $table): void
    {
        $singular = Str::singular($table);
        $path = convert_linux_path($this->getDestinationViewsFilePath($singular, 'index.blade.php'));
        $contents = $this->stubRender(
            'resource/views/index.stub',
            [
                'ROUTE_NAME' => $table,
            ]
        );

        $this->makeFile($path, $contents);

        $col2 = $this->getViewsFormCol2();
        $stubFile = $col2 ? 'form-2col.stub' : 'form.stub';

        $path = convert_linux_path($this->getDestinationViewsFilePath($singular, 'form.blade.php'));

        $contents = $this->stubRender(
            'resource/views/'.$stubFile,
            [
                'ROUTE_NAME' => $table,
                'FORM_COL1' => $this->getViewsFormCol1(),
                'FORM_COL2' => $this->getViewsFormCol2(),
            ]
        );

        $this->makeFile($path, $contents);
    }

    protected function addLanguageTranslate(): void
    {
        $path = $this->module->getPath('src/resources/lang/en/content.php');
        $langs = [];
        if (File::exists($path)) {
            $langs = include $path;
        }

        foreach ($this->columns as $column) {
            if (isset($langs[$column])) {
                continue;
            }

            $langs[$column] = Str::ucfirst(Str::replace('_', ' ', $column));
        }

        $string = '<?php' . PHP_EOL . PHP_EOL . 'return ' . $this->varExport($langs) . ';' . PHP_EOL;

        File::put($path, $string);
    }

    /**
     * Returns the file path of the destination controller for the given file.
     *
     * @param  mixed  $file  The file for which the destination controller file path is needed.
     * @return string The file path of the destination controller.
     */
    protected function getDestinationControllerFilePath(mixed $file): string
    {
        $controllerPath = $this->module->getPath().'/'.
            GenerateConfigReader::read('controller')->getPath().
            '/Backend/';

        if (!is_dir($controllerPath)) {
            File::makeDirectory($controllerPath, 0775, true);
        }

        return $controllerPath.'/'.$file;
    }

    /**
     * Retrieves the file path for the destination views of a given table and file.
     *
     * @param  string  $table  The name of the table.
     * @param  string  $file  The name of the file.
     * @return string The file path for the destination views.
     */
    protected function getDestinationViewsFilePath(string $table, string $file): string
    {
        $viewPath = $this->module->getPath().'/'.
            GenerateConfigReader::read('views')->getPath().
            '/backend/'.$table;

        if (!is_dir($viewPath)) {
            File::makeDirectory($viewPath, 0775, true);
        }

        return $viewPath.'/'.$file;
    }

    /**
     * Retrieves the views for column 1.
     *
     * This function filters the list of columns and retrieves the views
     * for column 1. It excludes any columns that are present in the
     * views for column 2. The views are rendered using a stub template
     * and the resulting strings are concatenated and returned.
     *
     * @return string The concatenated views for column 1.
     */
    protected function getViewsFormCol1(): string
    {
        $str = '';
        $columns = collect($this->columns)
            ->filter(fn($item) => !in_array($item, $this->getColumnsViewsFormCol2()))
            ->toArray();

        $index = 0;
        foreach ($columns as $column) {
            $prefix = $index != 0 ? "\n\n\t\t\t" : "";
            $str .= $prefix.$this->stubRender(
                $this->getColumnViewsStubPath($column),
                [
                    'COLUMN' => $column,
                    'MODULE_DOMAIN' => $this->module->getDomainName(),
                ]
            );

            $index++;
        }

        return $str;
    }

    /**
     * Retrieves the views for column 2.
     *
     * @return string The concatenated views for column 2.
     */
    protected function getViewsFormCol2(): string
    {
        $str = '';
        $columns = collect($this->columns)
            ->filter(fn($item) => in_array($item, $this->getColumnsViewsFormCol2()))
            ->toArray();

        $index = 0;
        foreach ($columns as $column) {
            $prefix = $index != 0 ? "\n\n\t\t\t" : "";
            $str .= $prefix.$this->stubRender(
                $this->getColumnViewsStubPath($column),
                [
                        'COLUMN' => $column,
                        'MODULE_DOMAIN' => $this->module->getDomainName(),
                    ]
            );

            $index++;
        }

        return $str;
    }

    /**
     * Retrieves the columns to be displayed in the second column of the views form.
     *
     * @return array The array of column names.
     */
    protected function getColumnsViewsFormCol2(): array
    {
        return [
            'status',
            'thumbnail',
        ];
    }

    /**
     * Retrieves the path to the stub file for a given column view.
     *
     * @param  string  $column  The name of the column.
     * @return string The path to the stub file.
     */
    protected function getColumnViewsStubPath(string $column): string
    {
        $stubPath = JW_PACKAGE_PATH.'/stubs/plugin/';
        $columnStub = 'resource/views/columns/'.$column.'.stub';

        if (file_exists($stubPath.'/'.$columnStub)) {
            return $columnStub;
        }

        return 'resource/views/default-column.stub';
    }

    protected function varExport($expression): string
    {
        $export = var_export($expression, true);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(
            ["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"],
            [null, ']$1', ' => ['],
            $array
        );
        return implode(PHP_EOL, array_filter(["["] + $array));
    }
}
