<?php

Route::get('/popular-movies', 'Frontend\AjaxGetController@getPopularMovies')->name('movies.popular');

Route::get('/movies-by-genre', 'Frontend\AjaxGetController@getMoviesByGenre')->name('movies.genre');