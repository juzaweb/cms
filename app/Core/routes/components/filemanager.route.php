<?php

Route::group(['prefix' => 'filemanager'], function () {
    Route::get('/', 'Backend\Filemanager\LfmController@show');
    
    Route::get('/errors', 'Backend\Filemanager\LfmController@getErrors');
    
    Route::any('/upload', 'Backend\Filemanager\UploadController@upload')->name('backend.filemanager.upload');
    
    Route::get('/jsonitems', 'Backend\Filemanager\ItemsController@getItems');
    
    Route::get('/move', 'Backend\Filemanager\ItemsController@move');
    
    Route::get('/domove', 'Backend\Filemanager\ItemsController@domove');
    
    Route::get('/newfolder', 'Backend\Filemanager\FolderController@getAddfolder');
    
    Route::get('/folders', 'Backend\Filemanager\FolderController@getFolders');
    
    Route::get('/rename', 'Backend\Filemanager\RenameController@getRename');
    
    Route::get('/download', 'Backend\Filemanager\DownloadController@getDownload');
    
    Route::get('/delete', 'Backend\Filemanager\DeleteController@getDelete');
});