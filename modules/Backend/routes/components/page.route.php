<?php

Route::get('imports', 'Backend\ImportController@index');
Route::post('imports', 'Backend\ImportController@import');

Route::get('pages/{slug}', 'Backend\PageController')->where('slug', '[a-z\-\/]+');

Route::jwResource(
    'managements/{slug}',
    'Backend\PageResourceController',
    [
        'where' => ['slug' => '[a-z\-\/]+']
    ]
);
