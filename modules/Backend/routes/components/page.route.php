<?php

Route::get('imports', 'Backend\ImportController@index');
Route::post('imports', 'Backend\ImportController@import');

/*Route::match(['get', 'post'], 'pages/{slug}', 'Backend\PageController@router')->where('slug', '[a-z\-\/]+');
Route::jwResource(
    'resource-pages/{slug}',
    'Backend\PageResourceController',
    [
        'where' => ['slug' => '[a-z\-\/]+']
    ]
);*/
