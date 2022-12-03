<?php

namespace Juzaweb\CMS\Support\Macros;

use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Controllers\Backend\TaxonomyController;
use Juzaweb\Backend\Http\Controllers\Backend\CommentController;

class RouterMacros
{
    public function jwResource(): \Closure
    {
        return function ($uri, $controller, $options = []) {
            if (! empty($options['name'])) {
                $routeName = $options['name'];
            } else {
                $routeName = str_replace(['{', '}'], '', $uri);
                $routeName = str_replace('/', '.', $routeName);
            }

            $where = $options['where'] ?? [];
            $routeName = 'admin.' . $routeName;

            $this->get($uri, "{$controller}@index")->name($routeName .'.index')->where($where);
            $this->get($uri . '/create', $controller . '@create')->name($routeName . '.create')->where($where);
            $this->get("{$uri}/datatable", $controller . '@datatable')->name($routeName . '.datatable')->where($where);
            $this->get($uri . '/{id}/edit', $controller . '@edit')->name($routeName . '.edit')
                ->where($where);
            $this->get($uri . '/load-data', $controller . '@getDataForSelect')
                ->name($routeName . '.load-data')
                ->where($where);
            $this->post($uri, $controller . '@store')->name($routeName . '.store')->where($where);
            $this->post("{$uri}/bulk-action", "{$controller}@bulkActions")
                ->name($routeName . '.bulk_action')
                ->where($where);
            $this->put($uri . '/{id}', $controller . '@update')->name($routeName . '.update')->where($where);
        };
    }

    public function postTypeResource()
    {
        return function ($uri, $controller, $options = []) {
            $singular = Str::singular($uri);
            $this->jwResource($uri, $controller, $options);
            $this->jwResource(
                "{$singular}/comments",
                '\\' . CommentController::class,
                [
                    'name' => $singular . '.comment',
                ]
            );

            $this->get($singular . '/{taxonomy}/component-item', ['\\'. TaxonomyController::class, 'getTagComponent']);

            $this->jwResource(
                "{$singular}/{taxonomy}",
                '\\'. TaxonomyController::class,
                [
                    'name' => $singular . '.taxonomy',
                ]
            );
        };
    }
}
