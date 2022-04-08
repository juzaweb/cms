<?php

Route::get('imports', 'Backend\ImportController@index');
Route::post('imports', 'Backend\ImportController@import');
