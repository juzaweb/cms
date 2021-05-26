<?php

Route::group(['prefix' => 'tmdb'], function () {
    Route::post('/add-movie', 'Backend\TmdbController@addMovie')->name('admin.tmdb.add_movie');
});