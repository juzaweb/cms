<?php

require_once __DIR__ . '/auth.route.php';
require_once __DIR__ . '/sitemap.route.php';
require_once __DIR__ . '/watch.route.php';

Route::group(['prefix' => 'account', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', 'Frontend\ProfileController@index')->name('account');
    
    Route::get('/change-password', 'Frontend\ChangePasswordController@index')->name('account.change_password');
});

Route::get('/', 'Frontend\HomeController@index')->name('home');

Route::get('/uploads/{path}', 'Frontend\StreamController@image')->name('uploads')->where('path', '(.*)');

Route::get('/search', 'Frontend\SearchController@search')->name('search');

Route::get('/popular-movies', 'Frontend\SearchController@getPopularMovies')->name('movies.popular');

Route::get('/movies', 'Frontend\MoviesController@index')->name('movies');

Route::get('/tv-series', 'Frontend\TVSeriesController@index')->name('tv_series');

Route::get('/genre/{slug}', 'Frontend\GenreController@index')->name('genre');

Route::get('/type/{slug}', 'Frontend\TypeController@index')->name('type');

Route::get('/country/{slug}', 'Frontend\CountryController@index')->name('country');

Route::get('/tag/{slug}', 'Frontend\TagController@index')->name('tag');

Route::get('/page/{slug}', 'Frontend\PageController@index')->name('page');