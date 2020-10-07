<?php

Route::group(['prefix' => 'movies'], function () {
    Route::get('/', 'Backend\Movie\MoviesController@index')->name('admin.movies');
    
    Route::get('/getdata', 'Backend\Movie\MoviesController@getData')->name('admin.movies.getdata');
    
    Route::get('/create', 'Backend\Movie\MoviesController@form')->name('admin.movies.create');
    
    Route::get('/edit/{id}', 'Backend\Movie\MoviesController@form')->name('admin.movies.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Movie\MoviesController@save')->name('admin.movies.save');
    
    Route::post('/remove', 'Backend\Movie\MoviesController@remove')->name('admin.movies.remove');
});

Route::group(['prefix' => 'movies/servers'], function () {
    Route::get('/{movie_id}', 'Backend\Movie\MovieServesController@index')->name('admin.movies.servers')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/getdata', 'Backend\Movie\MovieServesController@getData')->name('admin.movies.servers.getdata')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/create', 'Backend\Movie\MovieServesController@form')->name('admin.movies.servers.create')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/edit/{server_id}', 'Backend\Movie\MovieServesController@form')->name('admin.movies.servers.edit')->where('movie_id', '[0-9]+')->where('server_id', '[0-9]+');
    
    Route::post('/{movie_id}/save', 'Backend\Movie\MovieServesController@save')->name('admin.movies.servers.save')->where('movie_id', '[0-9]+');
    
    Route::post('/{movie_id}/remove', 'Backend\Movie\MovieServesController@remove')->name('admin.movies.servers.remove')->where('movie_id', '[0-9]+');
});

Route::group(['prefix' => 'movies/servers/upload'], function () {
    Route::get('/{server_id}', 'Backend\Movie\MovieUploadController@index')->name('admin.movies.servers.upload')->where('server_id', '[0-9]+');
    
    Route::get('/{server_id}/getdata', 'Backend\Movie\MovieUploadController@getData')->name('admin.movies.servers.upload.getdata')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/save', 'Backend\Movie\MovieUploadController@save')->name('admin.movies.servers.upload.save')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/remove', 'Backend\Movie\MovieUploadController@remove')->name('admin.movies.servers.upload.remove')->where('server_id', '[0-9]+');
    
    Route::get('/get-file', 'Backend\Movie\MovieUploadController@getFile')->name('admin.movies.servers.upload.getfile');
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
    Route::get('/{movie_id}', 'Backend\Movie\MovieServesController@index')->name('admin.tv_series.servers')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/getdata', 'Backend\Movie\MovieServesController@getData')->name('admin.tv_series.servers.getdata')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/create', 'Backend\Movie\MovieServesController@form')->name('admin.tv_series.servers.create')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/edit/{server_id}', 'Backend\Movie\MovieServesController@form')->name('admin.tv_series.servers.edit')->where('movie_id', '[0-9]+')->where('server_id', '[0-9]+');
    
    Route::post('/{movie_id}/save', 'Backend\Movie\MovieServesController@save')->name('admin.movies.servers.save')->where('movie_id', '[0-9]+');
    
    Route::post('/{movie_id}/remove', 'Backend\Movie\MovieServesController@remove')->name('admin.tv_series.servers.remove')->where('movie_id', '[0-9]+');
});

Route::group(['prefix' => 'tv-series/servers/upload'], function () {
    Route::get('/{server_id}', 'Backend\Movie\MovieUploadController@index')->name('admin.tv_series.servers.upload')->where('server_id', '[0-9]+');
    
    Route::get('/{server_id}/getdata', 'Backend\Movie\MovieUploadController@getData')->name('admin.tv_series.servers.upload.getdata')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/save', 'Backend\Movie\MovieUploadController@save')->name('admin.tv_series.servers.upload.save')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/remove', 'Backend\Movie\MovieUploadController@remove')->name('admin.tv_series.servers.upload.remove')->where('server_id', '[0-9]+');
    
    Route::get('/get-file', 'Backend\Movie\MovieUploadController@getFile')->name('admin.movies.tv_series.upload.getfile');
});

Route::group(['prefix' => 'movies/servers/upload/subtitle/{file_id}'], function () {
    Route::get('/', 'Backend\Movie\SubtitleController@index')->name('admin.movies.servers.upload.subtitle')->where('file_id', '[0-9]+');
    
    Route::get('create', 'Backend\Movie\SubtitleController@form')->name('admin.movies.servers.upload.subtitle.create')->where('file_id', '[0-9]+');
    
    Route::get('edit/{id}', 'Backend\Movie\SubtitleController@form')->name('admin.movies.servers.upload.subtitle.edit')->where('file_id', '[0-9]+')->where('id', '[0-9]+');
    
    Route::get('getdata', 'Backend\Movie\SubtitleController@getData')->name('admin.movies.servers.upload.subtitle.getdata')->where('file_id', '[0-9]+');
    
    Route::post('save', 'Backend\Movie\SubtitleController@save')->name('admin.movies.servers.upload.subtitle.save')->where('file_id', '[0-9]+');
    
    Route::post('remove', 'Backend\Movie\SubtitleController@remove')->name('admin.movies.servers.upload.subtitle.remove')->where('file_id', '[0-9]+');
});

Route::group(['prefix' => 'video-qualities'], function () {
    Route::get('/', 'Backend\Setting\VideoQualityController@index')->name('admin.video_qualities');
    
    Route::get('/getdata', 'Backend\Setting\VideoQualityController@getData')->name('admin.video_qualities.getdata');
    
    Route::get('/create', 'Backend\Setting\VideoQualityController@form')->name('admin.video_qualities.create');
    
    Route::get('/edit/{id}', 'Backend\Setting\VideoQualityController@form')->name('admin.video_qualities.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\VideoQualityController@save')->name('admin.video_qualities.save');
    
    Route::post('/remove', 'Backend\Setting\VideoQualityController@remove')->name('admin.video_qualities.remove');
});

Route::group(['prefix' => '{type}/download/{movie_id}'], function () {
    Route::get('/', 'Backend\Movie\DownloadController@index')->name('admin.movies.download');
    
    Route::get('/getdata', 'Backend\Movie\DownloadController@getData')->name('admin.movies.download.getdata');
    
    Route::get('/create', 'Backend\Movie\DownloadController@form')->name('admin.movies.download.create');
    
    Route::get('/edit/{id}', 'Backend\Movie\DownloadController@form')->name('admin.movies.download.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Movie\DownloadController@save')->name('admin.movies.download.save');
    
    Route::post('/remove', 'Backend\Movie\DownloadController@remove')->name('admin.movies.download.remove');
});