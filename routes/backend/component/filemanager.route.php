<?php

Route::group(['prefix' => 'filemanager2'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'filemanager'], function () {
    Route::get('/', 'Backend\FileManager\LfmController@show');
    
    Route::get('/errors', 'Backend\FileManager\LfmController@getErrors');
    
    Route::any('/upload', 'Backend\FileManager\UploadController@upload')->name('backend.filemanager.upload');
    
    Route::get('/jsonitems', 'Backend\FileManager\ItemsController@getItems');
    
    Route::get('/move', 'Backend\FileManager\ItemsController@move');
    
    Route::get('/domove', 'Backend\FileManager\ItemsController@domove');
    
    Route::get('/newfolder', 'Backend\FileManager\FolderController@getAddfolder');
    
    Route::get('/folders', 'Backend\FileManager\FolderController@getFolders');
    
    Route::get('/rename', 'Backend\FileManager\RenameController@getRename');
    
    Route::get('/download', 'Backend\FileManager\DownloadController@getDownload');
    
    Route::get('/delete', 'Backend\FileManager\DeleteController@getDelete');
});