<?php

Route::get('/watch/{slug}', 'Frontend\WatchController@index')->name('watch');

Route::get('/watch/{slug}/play.html', 'Frontend\WatchController@watch')->name('watch.play');

Route::post('/watch/player/{vfile_id}', 'Frontend\WatchController@getPlayer')->name('watch.player');

Route::get('/videos/{token}/{file}/{file_name}', 'Frontend\StreamController@video')->name('stream');