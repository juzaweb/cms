<?php

require_once __DIR__ . '/component/sitemap.route.php';
require_once __DIR__ . '/component/ajax_get.route.php';
require_once __DIR__ . '/component/stream.route.php';
require_once __DIR__ . '/component/auth.route.php';
require_once __DIR__ . '/component/watch.route.php';
require_once __DIR__ . '/component/account.route.php';
require_once __DIR__ . '/component/search.route.php';
require_once __DIR__ . '/component/post.route.php';

Route::get('/', 'Frontend\HomeController@index')->name('home');

Route::get('/latest-movies', 'Frontend\LatestMoviesController@index')->name('latest_movies');

Route::get('/movies', 'Frontend\MoviesController@index')->name('movies');

Route::get('/tv-series', 'Frontend\TVSeriesController@index')->name('tv_series');

Route::get('/genre/{slug}', 'Frontend\GenreController@index')->name('genre');

Route::get('/type/{slug}', 'Frontend\GenreController@index')->name('type');

Route::get('/country/{slug}', 'Frontend\GenreController@index')->name('country');

Route::get('/year/{slug}', 'Frontend\GenreController@index')->name('year');

Route::get('/tag/{slug}', 'Frontend\GenreController@index')->name('tag');

Route::get('/page/{slug}', 'Frontend\PageController@index')->name('page');

Route::get('/ads/videos.xml', 'Frontend\VideoAdsController@ads')->name('ads.videos');