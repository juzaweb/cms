<?php

namespace Tadcms\Backend\Macros;

class RouterMacros
{
    public function tadResource()
    {
        return function ($uri, $controller, $options = []) {
            $default = [
                'name' => '',
            ];
    
            $options = array_merge($default, $options);
            $uriName = $options['name'] ? $options['name'] :
                str_replace('/', '.', $uri);
            $uriName = 'admin.' . $uriName;
            
            $this->get($uri, $controller . '@index')->name($uriName .'.index');
            $this->get($uri . '/create', $controller . '@create')->name($uriName . '.create');
            $this->get($uri . '/{id}/edit', $controller . '@edit')->name($uriName . '.edit')->where('id', '[0-9]+');
            $this->post($uri, $controller . '@store')->name($uriName . '.store');
            $this->put($uri . '/{id}', $controller . '@update')->name($uriName . '.update');
            $this->delete($uri . '/{id}', $controller . '@destroy')->name($uriName . '.destroy');
            $this->get($uri . '/get-data', $controller . '@getDataTable')->name($uriName . '.get-data');
            
            $this->post($uri . '/bulk-actions', $controller . '@bulkActions')->name($uriName . '.bulk-actions');
        };
    }
}