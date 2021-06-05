<?php

namespace Mymo\Core\Macros;

use Illuminate\Support\Str;

class RouterMacros
{
    public function mymoResource()
    {
        return function ($uri, $controller, $options = []) {
            $uriName = $options['name'] ?? preg_replace('/[^a-z0-9\.]+/', '.', $uri);
            $uriName = 'admin.' . $uriName;

            $this->get($uri, $controller . '@index')->name($uriName .'.index');
            $this->get($uri . '/create', $controller . '@create')->name($uriName . '.create');
            $this->get($uri . '/{id}/edit', $controller . '@edit')->name($uriName . '.edit')->where('id', '[0-9]+');
            $this->post($uri, $controller . '@store')->name($uriName . '.store');
            $this->put($uri . '/{id}', $controller . '@update')->name($uriName . '.update');
            $this->get($uri . '/get-data', $controller . '@getDataTable')->name($uriName . '.get-data');
            
            $this->post($uri . '/bulk-actions', $controller . '@bulkActions')->name($uriName . '.bulk-actions');
        };
    }

    public function postTypeResource()
    {
        return function ($uri, $controller, $options = []) {
            $singular = Str::singular($uri);
            $this->mymoResource($uri, $controller, $options);
            //$this->mymoResource(Str::singular($uri) . '/comments', $controller, $options);
            $this->get($singular . '/{taxonomy}/component-item', '\Mymo\PostType\Http\Controllers\TaxonomyController@getTagComponent');
            $this->mymoResource($singular . '/{taxonomy}', '\Mymo\PostType\Http\Controllers\TaxonomyController', [
                'name' => Str::singular($uri) . '.taxonomy'
            ]);
        };
    }
}