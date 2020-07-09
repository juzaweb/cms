<?php
Route::group(['prefix' => 'filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => '/'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    
    Route::get('/load-data/{func}', 'Backend\LoadDataController@loadData')->name('admin.load_data');
});

Route::group(['prefix' => 'movies'], function () {
    Route::get('/', 'Backend\MoviesController@index')->name('admin.movies');
    
    Route::get('/getdata', 'Backend\MoviesController@getData')->name('admin.movies.getdata');
    
    Route::get('/create', 'Backend\MoviesController@form')->name('admin.movies.create');

    Route::get('/edit/{id}', 'Backend\MoviesController@form')->name('admin.movies.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\MoviesController@save')->name('admin.movies.save');
    
    Route::post('/remove', 'Backend\MoviesController@remove')->name('admin.movies.remove');
});

Route::group(['prefix' => 'movies/servers'], function () {
    Route::get('/{movie_id}', 'Backend\MovieServesController@index')->name('admin.movies.servers')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/getdata', 'Backend\MovieServesController@getData')->name('admin.movies.servers.getdata')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/create', 'Backend\MovieServesController@form')->name('admin.movies.servers.create')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/edit/{server_id}', 'Backend\MovieServesController@form')->name('admin.movies.servers.edit')->where('movie_id', '[0-9]+')->where('server_id', '[0-9]+');
    
    Route::post('/{movie_id}/save', 'Backend\MovieServesController@save')->name('admin.movies.servers.save')->where('movie_id', '[0-9]+');
    
    Route::post('/{movie_id}/remove', 'Backend\MovieServesController@remove')->name('admin.movies.servers.remove')->where('movie_id', '[0-9]+');
});

Route::group(['prefix' => 'movies/servers/upload'], function () {
    Route::get('/{server_id}', 'Backend\MovieUploadController@index')->name('admin.movies.servers.upload')->where('id', '[0-9]+');
    
    Route::get('/{server_id}/getdata', 'Backend\MovieUploadController@getData')->name('admin.movies.servers.upload.getdata')->where('id', '[0-9]+');
    
    Route::post('/{server_id}/save', 'Backend\MovieUploadController@save')->name('admin.movies.servers.upload.save')->where('id', '[0-9]+');
    
    Route::post('/{server_id}/remove', 'Backend\MovieUploadController@remove')->name('admin.movies.servers.upload.remove')->where('id', '[0-9]+');
    
    Route::post('/', 'Backend\MovieUploadController@upload')->name('admin.movies.servers.upload.post');
});

Route::group(['prefix' => 'tv-series'], function () {
    Route::get('/', 'Backend\TVSeriesController@index')->name('admin.tv_series');
    
    Route::get('/getdata', 'Backend\TVSeriesController@getData')->name('admin.tv_series.getdata');
    
    Route::get('/create', 'Backend\TVSeriesController@form')->name('admin.tv_series.create');
    
    Route::get('/edit/{id}', 'Backend\TVSeriesController@form')->name('admin.tv_series.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\TVSeriesController@save')->name('admin.tv_series.save');
    
    Route::post('/remove', 'Backend\TVSeriesController@remove')->name('admin.tv_series.remove');
});

Route::group(['prefix' => 'genres'], function () {
    Route::get('/', 'Backend\GenresController@index')->name('admin.genres');
    
    Route::get('/getdata', 'Backend\GenresController@getData')->name('admin.genres.getdata');
    
    Route::get('/create', 'Backend\GenresController@form')->name('admin.genres.create');

    Route::get('/edit/{id}', 'Backend\GenresController@form')->name('admin.genres.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\GenresController@save')->name('admin.genres.save');
    
    Route::post('/remove', 'Backend\GenresController@remove')->name('admin.genres.remove');
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

Route::group(['prefix' => 'tags'], function () {
    Route::post('/save', 'Backend\TagsController@save')->name('admin.tags.save');
});

Route::group(['prefix' => 'post-categories'], function () {
    Route::get('/', 'Backend\PostCategoriesController@index')->name('admin.post_categories');
    
    Route::get('/getdata', 'Backend\PostCategoriesController@getData')->name('admin.post_categories.getdata');
    
    Route::get('/create', 'Backend\PostCategoriesController@form')->name('admin.post_categories.create');
    
    Route::get('/edit/{id}', 'Backend\PostCategoriesController@form')->name('admin.post_categories.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\PostCategoriesController@save')->name('admin.post_categories.save');
    
    Route::post('/remove', 'Backend\PostCategoriesController@remove')->name('admin.post_categories.remove');
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

Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'Backend\UsersController@index')->name('admin.users');
    
    Route::get('/getdata', 'Backend\UsersController@getData')->name('admin.users.getdata');
    
    Route::get('/create', 'Backend\UsersController@form')->name('admin.users.create');
    
    Route::get('/edit/{id}', 'Backend\UsersController@form')->name('admin.users.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\UsersController@save')->name('admin.users.save');
    
    Route::post('/remove', 'Backend\UsersController@remove')->name('admin.users.remove');
});

Route::group(['prefix' => 'setting'], function () {
    Route::get('/', 'Backend\Setting\SystemSettingController@index')->name('admin.setting');
    
    Route::post('/save', 'Backend\Setting\SystemSettingController@save')->name('admin.setting.save');
});

Route::group(['prefix' => 'setting/comment'], function () {
    Route::get('/', 'Backend\Setting\CommentSettingController@index')->name('admin.setting.comment');
    
    Route::post('/save', 'Backend\Setting\CommentSettingController@save')->name('admin.setting.comment.save');
});

Route::group(['prefix' => 'setting/email'], function () {
    Route::get('/', 'Backend\Setting\EmailSettingController@index')->name('admin.setting.email');
    
    Route::post('/save', 'Backend\Setting\EmailSettingController@save')->name('admin.setting.email.save');
});

Route::group(['prefix' => 'setting/email-templates'], function () {
    Route::get('/', 'Backend\Setting\EmailTemplateController@index')->name('admin.setting.email_templates');
    
    Route::get('/getdata', 'Backend\Setting\EmailTemplateController@getData')->name('admin.setting.email_templates.getdata');
    
    Route::get('/create', 'Backend\Setting\EmailTemplateController@form')->name('admin.setting.email_templates.create');
    
    Route::get('/edit/{id}', 'Backend\Setting\EmailTemplateController@form')->name('admin.setting.email_templates.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\EmailTemplateController@save')->name('admin.setting.email_templates.save');
    
    Route::post('/remove', 'Backend\Setting\EmailTemplateController@remove')->name('admin.setting.email_templates.remove');
});

Route::group(['prefix' => 'settting/languages'], function () {
    Route::get('/', 'Backend\Setting\LanguagesController@index')->name('admin.languages');
    
    Route::get('/getdata', 'Backend\Setting\LanguagesController@getData')->name('admin.languages.getdata');
    
    Route::post('/save', 'Backend\Setting\LanguagesController@save')->name('admin.languages.save');
    
    Route::post('/remove', 'Backend\Setting\LanguagesController@remove')->name('admin.languages.remove');
    
    Route::post('/sync', 'Backend\Setting\LanguagesController@syncLanguage')->name('admin.languages.sync');
});

Route::group(['prefix' => 'settting/translate'], function () {
    Route::get('/{lang}', 'Backend\Setting\TranslateController@index')->name('admin.translate')->where('lang', '[a-z]+');
    
    Route::get('/{lang}/getdata', 'Backend\Setting\TranslateController@getData')->name('admin.translate.getdata')->where('lang', '[a-z]+');
    
    Route::post('/{lang}/save', 'Backend\Setting\TranslateController@save')->name('admin.translate.save')->where('lang', '[a-z]+');
});

Route::group(['prefix' => 'settting/video-qualities'], function () {
    Route::get('/', 'Backend\Setting\VideoQualityController@index')->name('admin.video_qualities');
    
    Route::get('/getdata', 'Backend\Setting\VideoQualityController@getData')->name('admin.video_qualities.getdata');
    
    Route::get('/create', 'Backend\Setting\VideoQualityController@form')->name('admin.video_qualities.create');
    
    Route::get('/edit/{id}', 'Backend\Setting\VideoQualityController@form')->name('admin.video_qualities.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\VideoQualityController@save')->name('admin.video_qualities.save');
    
    Route::post('/remove', 'Backend\Setting\VideoQualityController@remove')->name('admin.video_qualities.remove');
});