<?php

/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package mymocms/mymocms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://github.com/mymocms/mymocms
 */

Route::group(['prefix' => config('mymo_core.admin_prefix'), 'middleware' => ['web', 'admin']], function () {
    Route::group(['prefix' => '{type}/servers'], function () {
        Route::get('/{movie_id}',
            'Backend\MovieServesController@index')->name('admin.movies.servers')->where('movie_id', '[0-9]+');

        Route::get('/{movie_id}/getdata',
            'Backend\MovieServesController@getData')->name('admin.movies.servers.getdata')->where('movie_id',
            '[0-9]+');

        Route::get('/{movie_id}/create',
            'Backend\MovieServesController@form')->name('admin.movies.servers.create')->where('movie_id',
            '[0-9]+');

        Route::get('/{movie_id}/edit/{server_id}',
            'Backend\MovieServesController@form')->name('admin.movies.servers.edit')->where('movie_id',
            '[0-9]+')->where('server_id', '[0-9]+');

        Route::post('/{movie_id}/save',
            'Backend\MovieServesController@save')->name('admin.movies.servers.save')->where('movie_id', '[0-9]+');

        Route::post('/{movie_id}/remove',
            'Backend\MovieServesController@remove')->name('admin.movies.servers.remove')->where('movie_id',
            '[0-9]+');
    });

    Route::group(['prefix' => '{type}/servers/upload'], function () {
        Route::get('/{server_id}',
            'Backend\MovieUploadController@index')->name('admin.movies.servers.upload')->where('server_id',
            '[0-9]+');

        Route::get('/{server_id}/create',
            'Backend\MovieUploadController@form')->name('admin.movies.servers.upload.create')->where('server_id',
            '[0-9]+');

        Route::get('/{server_id}/edit/{id}',
            'Backend\MovieUploadController@form')->name('admin.movies.servers.upload.edit')->where('server_id',
            '[0-9]+')->where('id', '[0-9]+');

        Route::get('/{server_id}/getdata',
            'Backend\MovieUploadController@getData')->name('admin.movies.servers.upload.getdata')->where('server_id',
            '[0-9]+');

        Route::post('/{server_id}/save',
            'Backend\MovieUploadController@save')->name('admin.movies.servers.upload.save')->where('server_id',
            '[0-9]+');

        Route::post('/{server_id}/remove',
            'Backend\MovieUploadController@remove')->name('admin.movies.servers.upload.remove')->where('server_id',
            '[0-9]+');

    });

    Route::group(['prefix' => '{type}/servers/upload/subtitle/{file_id}'], function () {
        Route::get('/',
            'Backend\SubtitleController@index')->name('admin.movies.servers.upload.subtitle')->where('file_id',
            '[0-9]+');

        Route::get('create',
            'Backend\SubtitleController@form')->name('admin.movies.servers.upload.subtitle.create')->where('file_id',
            '[0-9]+');

        Route::get('edit/{id}',
            'Backend\SubtitleController@form')->name('admin.movies.servers.upload.subtitle.edit')->where('file_id',
            '[0-9]+')->where('id', '[0-9]+');

        Route::get('getdata',
            'Backend\SubtitleController@getData')->name('admin.movies.servers.upload.subtitle.getdata')->where('file_id',
            '[0-9]+');

        Route::post('save',
            'Backend\SubtitleController@save')->name('admin.movies.servers.upload.subtitle.save')->where('file_id',
            '[0-9]+');

        Route::post('remove',
            'Backend\SubtitleController@remove')->name('admin.movies.servers.upload.subtitle.remove')->where('file_id',
            '[0-9]+');
    });

    Route::group(['prefix' => '{type}/download/{movie_id}'], function () {
        Route::get('/', 'Backend\MovieDownloadController@index')->name('admin.movies.download');

        Route::get('/getdata', 'Backend\MovieDownloadController@getData')->name('admin.movies.download.getdata');

        Route::get('/create', 'Backend\MovieDownloadController@form')->name('admin.movies.download.create');

        Route::get('/edit/{id}',
            'Backend\MovieDownloadController@form')->name('admin.movies.download.edit')->where('id', '[0-9]+');

        Route::post('/save', 'Backend\MovieDownloadController@save')->name('admin.movies.download.save');

        Route::post('/remove', 'Backend\MovieDownloadController@remove')->name('admin.movies.download.remove');
    });

    Route::postTypeResource('movies', 'Backend\MovieController');

    Route::postTypeResource('tv-series', 'Backend\TVSerieController');

    require_once __DIR__ . '/backend/components/tmdb.route.php';
});

require __DIR__ . '/frontend/frontend.route.php';
