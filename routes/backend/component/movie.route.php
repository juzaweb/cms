<?php

Route::group(['prefix' => 'movies'], function () {
    Route::get('/', 'Backend\MoviesController@index')->name('admin.movies');
    
    Route::get('/getdata', 'Backend\MoviesController@getData')->name('admin.movies.getdata');
    
    Route::get('/create', 'Backend\MoviesController@form')->name('admin.movies.create');
    
    Route::get('/edit/{id}', 'Backend\MoviesController@form')->name('admin.movies.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\MoviesController@save')->name('admin.movies.save');
    
    Route::post('/remove', 'Backend\MoviesController@remove')->name('admin.movies.remove');
});

Route::group(['prefix' => 'movies/servers'], function () {
    Route::get('/{movie_id}', 'Backend\MovieServesController@index')->name('admin.movies.servers')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/getdata', 'Backend\MovieServesController@getData')->name('admin.movies.servers.getdata')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/create', 'Backend\MovieServesController@form')->name('admin.movies.servers.create')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/edit/{server_id}', 'Backend\MovieServesController@form')->name('admin.movies.servers.edit')->where('movie_id', '[0-9]+')->where('server_id', '[0-9]+');
    
    Route::post('/{movie_id}/save', 'Backend\MovieServesController@save')->name('admin.movies.servers.save')->where('movie_id', '[0-9]+');
    
    Route::post('/{movie_id}/remove', 'Backend\MovieServesController@remove')->name('admin.movies.servers.remove')->where('movie_id', '[0-9]+');
});

Route::group(['prefix' => 'movies/servers/upload'], function () {
    Route::get('/{server_id}', 'Backend\MovieUploadController@index')->name('admin.movies.servers.upload')->where('server_id', '[0-9]+');
    
    Route::get('/{server_id}/getdata', 'Backend\MovieUploadController@getData')->name('admin.movies.servers.upload.getdata')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/save', 'Backend\MovieUploadController@save')->name('admin.movies.servers.upload.save')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/remove', 'Backend\MovieUploadController@remove')->name('admin.movies.servers.upload.remove')->where('server_id', '[0-9]+');
    
    Route::get('/get-file', 'Backend\MovieUploadController@getFile')->name('admin.movies.servers.upload.getfile');
});

Route::group(['prefix' => 'tv-series'], function () {
    Route::get('/', 'Backend\TVSeriesController@index')->name('admin.tv_series');
    
    Route::get('/getdata', 'Backend\TVSeriesController@getData')->name('admin.tv_series.getdata');
    
    Route::get('/create', 'Backend\TVSeriesController@form')->name('admin.tv_series.create');
    
    Route::get('/edit/{id}', 'Backend\TVSeriesController@form')->name('admin.tv_series.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\TVSeriesController@save')->name('admin.tv_series.save');
    
    Route::post('/remove', 'Backend\TVSeriesController@remove')->name('admin.tv_series.remove');
});

Route::group(['prefix' => 'tv-series/servers'], function () {
    Route::get('/{movie_id}', 'Backend\MovieServesController@index')->name('admin.tv_series.servers')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/getdata', 'Backend\MovieServesController@getData')->name('admin.tv_series.servers.getdata')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/create', 'Backend\MovieServesController@form')->name('admin.tv_series.servers.create')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/edit/{server_id}', 'Backend\MovieServesController@form')->name('admin.tv_series.servers.edit')->where('movie_id', '[0-9]+')->where('server_id', '[0-9]+');
    
    Route::post('/{movie_id}/save', 'Backend\MovieServesController@save')->name('admin.movies.servers.save')->where('movie_id', '[0-9]+');
    
    Route::post('/{movie_id}/remove', 'Backend\MovieServesController@remove')->name('admin.tv_series.servers.remove')->where('movie_id', '[0-9]+');
});

Route::group(['prefix' => 'tv-series/servers/upload'], function () {
    Route::get('/{server_id}', 'Backend\MovieUploadController@index')->name('admin.tv_series.servers.upload')->where('server_id', '[0-9]+');
    
    Route::get('/{server_id}/getdata', 'Backend\MovieUploadController@getData')->name('admin.tv_series.servers.upload.getdata')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/save', 'Backend\MovieUploadController@save')->name('admin.tv_series.servers.upload.save')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/remove', 'Backend\MovieUploadController@remove')->name('admin.tv_series.servers.upload.remove')->where('server_id', '[0-9]+');
    
    Route::get('/get-file', 'Backend\MovieUploadController@getFile')->name('admin.movies.tv_series.upload.getfile');
});

Route::group(['prefix' => 'video-qualities'], function () {
    Route::get('/', 'Backend\Setting\VideoQualityController@index')->name('admin.video_qualities');
    
    Route::get('/getdata', 'Backend\Setting\VideoQualityController@getData')->name('admin.video_qualities.getdata');
    
    Route::get('/create', 'Backend\Setting\VideoQualityController@form')->name('admin.video_qualities.create');
    
    Route::get('/edit/{id}', 'Backend\Setting\VideoQualityController@form')->name('admin.video_qualities.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\VideoQualityController@save')->name('admin.video_qualities.save');
    
    Route::post('/remove', 'Backend\Setting\VideoQualityController@remove')->name('admin.video_qualities.remove');
});