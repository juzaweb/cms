<?php
Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'admin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
});

Route::group(['prefix' => 'admin/movies', 'middleware' => ['web', 'admin']], function () {
    Route::livewire('/', 'movies.index')->name('admin.movies')->layout('layouts.backend');
    
    Route::livewire('/create', 'movies.form')->name('admin.movies.create')->layout('layouts.backend');
    
    Route::livewire('/edit/{id}', 'movies.form')->name('admin.movies.edit')->where('id', '[0-9]+')->layout('layouts.backend');
});

Route::group(['prefix' => 'admin/genres', 'middleware' => ['web', 'admin']], function () {
    Route::livewire('/', 'genres.index')->name('admin.genres')->layout('layouts.backend');
    
    Route::livewire('/create', 'genres.form')->name('admin.genres.create')->layout('layouts.backend');
    
    Route::livewire('/edit/{id}', 'genres.form')->name('admin.genres.edit')->where('id', '[0-9]+')->layout('layouts.backend');
});

Route::group(['prefix' => 'admin/countries', 'middleware' => ['web', 'admin']], function () {
    Route::livewire('/', 'countries.index')->name('admin.countries')->layout('layouts.backend');
    
    Route::livewire('/create', 'countries.form')->name('admin.countries.create')->layout('layouts.backend');
    
    Route::livewire('/edit/{id}', 'countries.form')->name('admin.countries.edit')->where('id', '[0-9]+')->layout('layouts.backend');
});