<?php

Route::get('/', 'Frontend\HomeController@index')->name('home');

Route::get('/login', 'Frontend\LoginController@index')->name('login');

Route::get('/register', 'Frontend\RegisterController@index')->name('register');

Route::get('/search', 'Frontend\SearchController@search')->name('search');

Route::get('/popular-movies', 'Frontend\SearchController@getPopularMovies')->name('movies.popular');

Route::get('/movies', 'Frontend\MoviesController@index')->name('movies');

Route::get('/movies/page-{page}', 'Frontend\MoviesController@index')->name('movies.page');

Route::get('/tv-series', 'Frontend\TVSeriesController@index')->name('tv_series');

Route::get('/tv-series/page-{page}', 'Frontend\TVSeriesController@index')->name('tv_series.page');

Route::get('/genre/{slug}', 'Frontend\GenreController@index')->name('genre');

Route::get('/genre/{slug}/page-{page}', 'Frontend\GenreController@index')->name('genre.page')->where('page', '[0-9]+');

Route::get('/country/{slug}', 'Frontend\CountryController@index')->name('country');

Route::get('/country/{slug}/page-{page}', 'Frontend\CountryController@index')->name('country.page')->where('page', '[0-9]+');

Route::get('/tag/{slug}', 'Frontend\TagController@index')->name('tag');

Route::get('/tag/{slug}/page-{page}', 'Frontend\TagController@index')->name('tag.page');

Route::get('/watch/{slug}', 'Frontend\WatchController@index')->name('watch');

Route::get('/watch/{slug}/play.html', 'Frontend\WatchController@watch')->name('watch.play');