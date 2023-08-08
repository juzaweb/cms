<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\FileManager\FileManagerController;
use Juzaweb\Backend\Http\Controllers\FileManager\UploadController;
use Juzaweb\Backend\Http\Controllers\FileManager\ItemsController;
use Juzaweb\Backend\Http\Controllers\FileManager\FolderController;
use Juzaweb\Backend\Http\Controllers\FileManager\DeleteController;

Route::group(
    ['prefix' => 'file-manager'],
    function () {
        Route::get('/', 'FileManager\FileManagerController@index');

        Route::get('/errors', 'FileManager\FileManagerController@getErrors');

        Route::any('/upload', 'FileManager\UploadController@upload')->name('filemanager.upload');

        Route::any('/import', 'FileManager\UploadController@import')->name('filemanager.import');

        Route::get('/jsonitems', 'FileManager\ItemsController@getItems');

        /*Route::get('/move', 'ItemsController@move');

        Route::get('/domove', 'ItemsController@domove');*/

        Route::post('/newfolder', 'FileManager\FolderController@addfolder');

        Route::get('/folders', 'FileManager\FolderController@getFolders');

        /*Route::get('/rename', 'RenameController@getRename');

        Route::get('/download', 'DownloadController@getDownload');*/

        Route::post('/delete', 'FileManager\DeleteController@delete');
    }
);
