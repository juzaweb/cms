<?php

require_once __DIR__ . '/component/design.route.php';
require_once __DIR__ . '/component/setting.route.php';
require_once __DIR__ . '/component/filemanager.route.php';
require_once __DIR__ . '/component/movie.route.php';

Route::group(['prefix' => '/'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    
    Route::get('/load-data/{func}', 'Backend\LoadDataController@loadData')->name('admin.load_data');
});

Route::group(['prefix' => 'genres'], function () {
    Route::get('/', 'Backend\GenresController@index')->name('admin.genres');
    
    Route::get('/getdata', 'Backend\GenresController@getData')->name('admin.genres.getdata');
    
    Route::get('/create', 'Backend\GenresController@form')->name('admin.genres.create');

    Route::get('/edit/{id}', 'Backend\GenresController@form')->name('admin.genres.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\GenresController@save')->name('admin.genres.save');
    
    Route::post('/remove', 'Backend\GenresController@remove')->name('admin.genres.remove');
});

Route::group(['prefix' => 'types'], function () {
    Route::get('/', 'Backend\TypesController@index')->name('admin.types');
    
    Route::get('/getdata', 'Backend\TypesController@getData')->name('admin.types.getdata');
    
    Route::get('/create', 'Backend\TypesController@form')->name('admin.types.create');
    
    Route::get('/edit/{id}', 'Backend\TypesController@form')->name('admin.types.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\TypesController@save')->name('admin.types.save');
    
    Route::post('/remove', 'Backend\TypesController@remove')->name('admin.types.remove');
});

Route::group(['prefix' => 'countries'], function () {
    Route::get('/', 'Backend\CountriesController@index')->name('admin.countries');
    
    Route::get('/getdata', 'Backend\CountriesController@getData')->name('admin.countries.getdata');
    
    Route::get('/create', 'Backend\CountriesController@form')->name('admin.countries.create');

    Route::get('/edit/{id}', 'Backend\CountriesController@form')->name('admin.countries.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\CountriesController@save')->name('admin.countries.save');
    
    Route::post('/remove', 'Backend\CountriesController@remove')->name('admin.countries.remove');
});

Route::group(['prefix' => 'stars'], function () {
    Route::get('/', 'Backend\StarsController@index')->name('admin.stars');
    
    Route::get('/getdata', 'Backend\StarsController@getData')->name('admin.stars.getdata');
    
    Route::get('/create', 'Backend\StarsController@form')->name('admin.stars.create');
    
    Route::get('/edit/{id}', 'Backend\StarsController@form')->name('admin.stars.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\StarsController@save')->name('admin.stars.save');
    
    Route::post('/remove', 'Backend\StarsController@remove')->name('admin.stars.remove');
});

Route::group(['prefix' => 'pages'], function () {
    Route::get('/', 'Backend\PagesController@index')->name('admin.pages');
    
    Route::get('/getdata', 'Backend\PagesController@getData')->name('admin.pages.getdata');
    
    Route::get('/create', 'Backend\PagesController@form')->name('admin.pages.create');
    
    Route::get('/edit/{id}', 'Backend\PagesController@form')->name('admin.pages.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\PagesController@save')->name('admin.pages.save');
    
    Route::post('/remove', 'Backend\PagesController@remove')->name('admin.pages.remove');
});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', 'Backend\PostsController@index')->name('admin.posts');
    
    Route::get('/getdata', 'Backend\PostsController@getData')->name('admin.posts.getdata');
    
    Route::get('/create', 'Backend\PostsController@form')->name('admin.posts.create');
    
    Route::get('/edit/{id}', 'Backend\PostsController@form')->name('admin.posts.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\PostsController@save')->name('admin.posts.save');
    
    Route::post('/remove', 'Backend\PostsController@remove')->name('admin.posts.remove');
});

Route::group(['prefix' => 'post-categories'], function () {
    Route::get('/', 'Backend\PostCategoriesController@index')->name('admin.post_categories');
    
    Route::get('/getdata', 'Backend\PostCategoriesController@getData')->name('admin.post_categories.getdata');
    
    Route::get('/create', 'Backend\PostCategoriesController@form')->name('admin.post_categories.create');
    
    Route::get('/edit/{id}', 'Backend\PostCategoriesController@form')->name('admin.post_categories.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\PostCategoriesController@save')->name('admin.post_categories.save');
    
    Route::post('/remove', 'Backend\PostCategoriesController@remove')->name('admin.post_categories.remove');
});

Route::group(['prefix' => 'tags'], function () {
    Route::post('/save', 'Backend\TagsController@save')->name('admin.tags.save');
});

Route::group(['prefix' => 'comments/movie'], function () {
    Route::get('/', 'Backend\MovieCommentsController@index')->name('admin.movie_comments');
    
    Route::get('/getdata', 'Backend\MovieCommentsController@getData')->name('admin.movie_comments.getdata');
    
    Route::post('/remove', 'Backend\MovieCommentsController@remove')->name('admin.movie_comments.remove');
    
    Route::post('/approve', 'Backend\MovieCommentsController@approve')->name('admin.movie_comments.approve');
    
    Route::post('/', 'Backend\MovieCommentsController@publicis')->name('admin.movie_comments.publicis');
});

Route::group(['prefix' => 'comments/post'], function () {
    Route::get('/', 'Backend\PostCommentsController@index')->name('admin.post_comments');
    
    Route::get('/getdata', 'Backend\PostCommentsController@getData')->name('admin.post_comments.getdata');
    
    Route::post('/remove', 'Backend\PostCommentsController@remove')->name('admin.post_comments.remove');
    
    Route::post('/approve', 'Backend\PostCommentsController@approve')->name('admin.post_comments.approve');
    
    Route::post('/', 'Backend\PostCommentsController@publicis')->name('admin.post_comments.publicis');
});

Route::group(['prefix' => 'comments/setting'], function () {
    Route::get('/', 'Backend\Setting\CommentSettingController@index')->name('admin.setting.comment');
    
    Route::post('/save', 'Backend\Setting\CommentSettingController@save')->name('admin.setting.comment.save');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'Backend\UsersController@index')->name('admin.users');
    
    Route::get('/getdata', 'Backend\UsersController@getData')->name('admin.users.getdata');
    
    Route::get('/create', 'Backend\UsersController@form')->name('admin.users.create');
    
    Route::get('/edit/{id}', 'Backend\UsersController@form')->name('admin.users.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\UsersController@save')->name('admin.users.save');
    
    Route::post('/remove', 'Backend\UsersController@remove')->name('admin.users.remove');
});

Route::group(['prefix' => 'notification'], function () {
    Route::get('/', 'Backend\SendNotificationController@index')->name('admin.notification');
    
    Route::get('/getdata', 'Backend\SendNotificationController@getData')->name('admin.notification.getdata');
    
    Route::get('/create', 'Backend\SendNotificationController@form')->name('admin.notification.create');
    
    Route::get('/edit/{id}', 'Backend\SendNotificationController@form')->name('admin.notification.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\SendNotificationController@save')->name('admin.notification.save');
    
    Route::post('/remove', 'Backend\SendNotificationController@remove')->name('admin.notification.remove');
});

Route::group(['prefix' => 'logs/email'], function () {
    Route::get('/', 'Backend\Logs\EmailLogsController@index')->name('admin.logs.email');
    
    Route::get('/getdata', 'Backend\Logs\EmailLogsController@getData')->name('admin.logs.email.getdata');
    
    Route::post('/remove', 'Backend\Logs\EmailLogsController@remove')->name('admin.logs.email.remove');
});