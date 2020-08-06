<?php

Route::get('/watch/{slug}', 'Frontend\WatchController@index')->name('watch');

Route::get('/watch/{slug}/play-{vid}.html', 'Frontend\PlayController@index')->name('watch.play')->where('vid', '[0-9]+');

Route::post('/watch/{slug}/set-view', 'Frontend\PlayController@setMovieView')->name('watch.set_view');

Route::post('/watch/{slug}/rating', 'Frontend\RatingController@setRating')->name('watch.rating');

Route::post('/watch/player/{slug}/{vid}', 'Frontend\PlayController@getPlayer')->name('watch.player');

Route::post('/watch/{movie_id}/comment', 'Frontend\CommentController@comment')->name('watch.comment');