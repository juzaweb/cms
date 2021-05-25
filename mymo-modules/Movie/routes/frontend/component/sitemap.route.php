<?php

Route::get('/sitemap.xml', 'Frontend\SitemapController@index')->name('sitemap');

/*movies*/
Route::get('/sitemap/movies.xml', 'Frontend\SitemapController@sitemapMovies')->name('sitemap.movies');

Route::get('/sitemap/movies-list-{page}.xml', 'Frontend\SitemapController@sitemapMoviesList')->name('sitemap.movies.list')->where('page', '[0-9]+');

/*tv-series*/
Route::get('/sitemap/tv-series.xml', 'Frontend\SitemapController@sitemapTVSeries')->name('sitemap.tv_series');

Route::get('/sitemap/tv-series-list-{page}.xml', 'Frontend\SitemapController@sitemapTVSeriesList')->name('sitemap.tv_series.list')->where('page', '[0-9]+');

/*genres*/
Route::get('/sitemap/genres.xml', 'Frontend\SitemapController@sitemapGenres')->name('sitemap.genres');

Route::get('/sitemap/genres-list-{page}.xml', 'Frontend\SitemapController@sitemapGenresList')->name('sitemap.genres.list')->where('page', '[0-9]+');

/*countries*/
Route::get('/sitemap/countries.xml', 'Frontend\SitemapController@sitemapCountries')->name('sitemap.countries');

Route::get('/sitemap/countries-list-{page}.xml', 'Frontend\SitemapController@sitemapCountriesList')->name('sitemap.countries.list')->where('page', '[0-9]+');

/*post-categories*/
Route::get('/sitemap/post-categories.xml', 'Frontend\SitemapController@sitemapPostCategories')->name('sitemap.post_categories');

Route::get('/sitemap/post-categories-list-{page}.xml', 'Frontend\SitemapController@sitemapPostCategoriesList')->name('sitemap.post_categories.list')->where('page', '[0-9]+');

/*posts*/
Route::get('/sitemap/posts.xml', 'Frontend\SitemapController@sitemapPosts')->name('sitemap.posts');

Route::get('/sitemap/posts-list-{page}.xml', 'Frontend\SitemapController@sitemapPostsList')->name('sitemap.posts.list')->where('page', '[0-9]+');