<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Abstracts;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Juzaweb\Support\Config\GenerateConfigReader;
use Juzaweb\Traits\ModuleCommandTrait;

abstract class ResourceCommand extends Command
{
    use ModuleCommandTrait;
    /**
     * @var \Juzaweb\Abstracts\Plugin
     */
    protected $module;

    /**
     * @var array
     */
    protected $columns;

    protected function makeModel($table, $model)
    {
        $this->call('plugin:make-model', [
            'model' => $model,
            'module' => $this->getModuleName(),
            '--table' => $table,
            '--stub' => 'resource/model.stub',
            '--fillable' => implode(',', $this->columns),
        ]);
    }

    protected function makeDataTable($model)
    {
        $this->call('plugin:make-datatable', [
            'name' => $model,
            'module' => $this->getModuleName(),
            '--model' => $model,
            '--columns' => implode(',', $this->columns),
        ]);
    }

    protected function makeController($table, $model)
    {
        $file = $model . 'Controller.php';
        $path = $this->getDestinationControllerFilePath($file);

        $contents = $this->stubRender('resource/controller.stub', [
            'CLASS_NAMESPACE' => $this->module->getNamespace() . 'Http\Controllers\Backend',
            'DATATABLE' => $model . 'Datatable',
            'MODEL_NAME' => $model,
            'MODULE_NAMESPACE' => $this->module->getNamespace(),
            'CLASS' => $model . 'Controller',
            'TABLE_NAME' => $table,
            'VIEW_NAME' => Str::singular($table),
            'MODULE_DOMAIN' => $this->module->getDomainName(),
        ]);

        $this->makeFile($path, $contents);
    }

    protected function makeViews($table)
    {
        $singular = Str::singular($table);
        $path = convert_linux_path($this->getDestinationViewsFilePath($singular, 'index.blade.php'));
        $contents = $this->stubRender('resource/views/index.stub', [
            'ROUTE_NAME' => $table,
        ]);

        $this->makeFile($path, $contents);

        $col2 = $this->getViewsFormCol2();
        $stubFile = $col2 ? 'form-2col.stub' : 'form.stub';

        $path = convert_linux_path($this->getDestinationViewsFilePath($singular, 'form.blade.php'));

        $contents = $this->stubRender('resource/views/'. $stubFile, [
            'ROUTE_NAME' => $table,
            'FORM_COL1' => $this->getViewsFormCol1(),
            'FORM_COL2' => $this->getViewsFormCol2(),
        ]);

        $this->makeFile($path, $contents);
    }

    protected function getDestinationControllerFilePath($file)
    {
        $controllerPath = $this->module->getPath() .'/'.
            GenerateConfigReader::read('controller')->getPath() .
            '/Backend/';

        if (! is_dir($controllerPath)) {
            File::makeDirectory($controllerPath, 0775, true);
        }

        return $controllerPath . '/' . $file;
    }

    protected function getDestinationViewsFilePath($table, $file)
    {
        $viewPath = $this->module->getPath() .'/'.
            GenerateConfigReader::read('views')->getPath() .
            '/backend/' . $table;

        if (! is_dir($viewPath)) {
            File::makeDirectory($viewPath, 0775, true);
        }

        return $viewPath . '/' . $file;
    }

    protected function getViewsFormCol1()
    {
        $str = '';
        $columns = collect($this->columns)
            ->filter(function ($item) {
                return ! in_array($item, $this->getColumnsViewsFormCol2());
            })->toArray();

        $index = 0;
        foreach ($columns as $column) {
            $prefix = $index != 0 ? "\n\n\t\t\t" : "";
            $str .= $prefix . $this->stubRender(
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

    protected function getViewsFormCol2()
    {
        $str = '';
        $columns = collect($this->columns)
            ->filter(function ($item) {
                return in_array($item, $this->getColumnsViewsFormCol2());
            })->toArray();

        $index = 0;
        foreach ($columns as $column) {
            $prefix = $index != 0 ? "\n\n\t\t\t" : "";
            $str .= $prefix . $this->stubRender(
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

    protected function getColumnsViewsFormCol2()
    {
        return [
            'status',
            'thumbnail',
        ];
    }

    protected function getColumnViewsStubPath($column)
    {
        $stubPath = JW_PACKAGE_PATH . '/stubs/plugin/';
        $columnStub = 'resource/views/columns/' . $column . '.stub';

        if (file_exists($stubPath . '/' . $columnStub)) {
            return $columnStub;
        }

        return 'resource/views/default-column.stub';
    }
}
