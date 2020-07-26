<?php

require_once __DIR__ . '/component/sitemap.route.php';
require_once __DIR__ . '/component/ajax_get.route.php';
require_once __DIR__ . '/component/stream.route.php';
require_once __DIR__ . '/component/auth.route.php';
require_once __DIR__ . '/component/watch.route.php';
require_once __DIR__ . '/component/account.route.php';

Route::get('/', 'Frontend\HomeController@index')->name('home');

Route::get('/search', 'Frontend\SearchController@search')->name('search');

Route::get('/latest-movies', 'Frontend\LatestMoviesController@index')->name('latest_movies');

Route::get('/movies', 'Frontend\MoviesController@index')->name('movies');

Route::get('/tv-series', 'Frontend\TVSeriesController@index')->name('tv_series');

Route::get('/genre/{slug}', 'Frontend\GenreController@index')->name('genre');

Route::get('/type/{slug}', 'Frontend\TypeController@index')->name('type');

Route::get('/country/{slug}', 'Frontend\CountryController@index')->name('country');

Route::get('/tag/{slug}', 'Frontend\TagController@index')->name('tag');

Route::get('/page/{slug}', 'Frontend\PageController@index')->name('page');