<?php

Route::get('/watch/{slug}', 'Frontend\WatchController@index')->name('watch');

Route::get('/watch/{slug}/play-{vid}.html', 'Frontend\WatchController@watch')->name('watch.play')->where('vid', '[0-9]+');

Route::post('/watch/player/{slug}', 'Frontend\WatchController@getPlayer')->name('watch.player');

Route::get('/videos/{token}/{file}/{file_name}', 'Frontend\StreamController@video')->name('stream');