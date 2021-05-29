<?php

Route::group([
    'prefix' => 'admin-cp/file-manager',
    'middleware' => ['web', 'admin']
], function ()
{
    Route::get('/', 'FilemanagerController@show');

    Route::get('/errors', 'FilemanagerController@getErrors');

    Route::any('/upload', 'UploadController@upload')->name('filemanager.upload');

    Route::get('/jsonitems', 'ItemsController@getItems');

    Route::get('/move', 'ItemsController@move');

    Route::get('/domove', 'ItemsController@domove');

    Route::get('/new-folder', 'FolderController@getAddfolder');

    Route::get('/folders', 'FolderController@getFolders');

    Route::get('/rename', 'RenameController@getRename');

    Route::get('/download', 'DownloadController@getDownload');

    Route::get('/delete', 'DeleteController@getDelete');
});
