<?php

Route::get('/search', 'Frontend\SearchController@search')->name('search');

Route::get('/search-form', 'Frontend\SearchController@filterForm')->name('search.form');