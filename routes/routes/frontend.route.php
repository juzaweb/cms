<?php

Route::group(['middleware' => ['web', 'guest']], function () {
    Route::get('/login', 'Frontend\Auth\LoginController@index')->name('login');
    
    Route::post('/login', 'Frontend\Auth\LoginController@login')->name('login.submit');
    
    Route::get('/register', 'Frontend\Auth\RegisterController@index')->name('register');
    
    Route::post('/register', 'Frontend\Auth\RegisterController@register')->name('register.submit');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/logout', 'Frontend\Auth\LoginController@logout')->name('logout');
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

Route::get('/watch/{slug}', 'Frontend\WatchController@index')->name('watch');

Route::get('/watch/{slug}/play.html', 'Frontend\WatchController@watch')->name('watch.play');

Route::get('/page/{slug}', 'Frontend\PageController@index')->name('page');