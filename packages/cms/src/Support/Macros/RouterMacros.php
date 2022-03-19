<?php

namespace Juzaweb\Support\Macros;

use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Controllers\Backend\TaxonomyController;
use Juzaweb\Backend\Http\Controllers\Backend\CommentController;

class RouterMacros
{
    public function jwResource()
    {
        return function ($uri, $controller, $options = []) {
            if (! empty($options['name'])) {
                $routeName = $options['name'];
            } else {
                $routeName = str_replace(['{', '}'], '', $uri);
                $routeName = str_replace('/', '.', $routeName);
            }

            $routeName = 'admin.' . $routeName;

            $this->get($uri, $controller . '@index')->name($routeName .'.index');
            $this->get($uri . '/create', $controller . '@create')->name($routeName . '.create');
            $this->get($uri . '/{id}/edit', $controller . '@edit')->name($routeName . '.edit')->where('id', '[0-9]+');
            $this->get($uri . '/load-data', $controller . '@getDataForSelect')->name($routeName . '.load-data');
            $this->post($uri, $controller . '@store')->name($routeName . '.store');
            $this->put($uri . '/{id}', $controller . '@update')->name($routeName . '.update');
        };
    }

    public function postTypeResource()
    {
        return function ($uri, $controller, $options = []) {
            $singular = Str::singular($uri);
            $this->jwResource($uri, $controller, $options);
            $this->jwResource($singular . '/comments', '\\' . CommentController::class, [
                'name' => $singular . '.comment',
            ]);

            $this->get($singular . '/{taxonomy}/component-item', ['\\'. TaxonomyController::class, 'getTagComponent']);

            $this->jwResource($singular . '/{taxonomy}', '\\'. TaxonomyController::class, [
                'name' => $singular . '.taxonomy',
            ]);
        };
    }
}
