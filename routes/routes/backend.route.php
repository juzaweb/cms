<?php
Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'admin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
});

//Route::group(['prefix' => 'admin/movies', 'middleware' => ['web', 'admin']], function () {
//    Route::get('/', 'movies.index')->name('admin.movies');
//
//    Route::get('/create', 'movies.form')->name('admin.movies.create');
//
//    Route::get('/edit/{id}', 'movies.form')->name('admin.movies.edit')->where('id', '[0-9]+');
//});

Route::group(['prefix' => 'admin/genres', 'middleware' => ['web', 'admin']], function () {
    Route::get('/', 'Backend\GenresController@index')->name('admin.genres');
    
    Route::get('/getdata', 'Backend\GenresController@getData')->name('admin.genres.getdata');
    
    Route::get('/create', 'Backend\GenresController@form')->name('admin.genres.create');

    Route::get('/edit/{id}', 'Backend\GenresController@form')->name('admin.genres.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\GenresController@save')->name('admin.genres.save');
    
    Route::post('/remove', 'Backend\GenresController@remove')->name('admin.genres.remove');
});

//Route::group(['prefix' => 'admin/countries', 'middleware' => ['web', 'admin']], function () {
//    Route::get('/', 'countries.index')->name('admin.countries');
//
//    Route::get('/create', 'countries.form')->name('admin.countries.create');
//
//    Route::get('/edit/{id}', 'countries.form')->name('admin.countries.edit')->where('id', '[0-9]+');
//});