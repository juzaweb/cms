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
    Route::get('/{server_id}', 'Backend\MovieUploadController@index')->name('admin.movies.servers.upload')->where('server_id', '[0-9]+');
    
    Route::get('/{server_id}/getdata', 'Backend\MovieUploadController@getData')->name('admin.movies.servers.upload.getdata')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/save', 'Backend\MovieUploadController@save')->name('admin.movies.servers.upload.save')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/remove', 'Backend\MovieUploadController@remove')->name('admin.movies.servers.upload.remove')->where('server_id', '[0-9]+');
    
    Route::get('/get-file', 'Backend\MovieUploadController@getFile')->name('admin.movies.servers.upload.getfile');
});

Route::group(['prefix' => 'tv-series'], function () {
    Route::get('/', 'Backend\TVSeriesController@index')->name('admin.tv_series');
    
    Route::get('/getdata', 'Backend\TVSeriesController@getData')->name('admin.tv_series.getdata');
    
    Route::get('/create', 'Backend\TVSeriesController@form')->name('admin.tv_series.create');
    
    Route::get('/edit/{id}', 'Backend\TVSeriesController@form')->name('admin.tv_series.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\TVSeriesController@save')->name('admin.tv_series.save');
    
    Route::post('/remove', 'Backend\TVSeriesController@remove')->name('admin.tv_series.remove');
});

Route::group(['prefix' => 'tv-series/servers'], function () {
    Route::get('/{movie_id}', 'Backend\MovieServesController@index')->name('admin.tv_series.servers')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/getdata', 'Backend\MovieServesController@getData')->name('admin.tv_series.servers.getdata')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/create', 'Backend\MovieServesController@form')->name('admin.tv_series.servers.create')->where('movie_id', '[0-9]+');
    
    Route::get('/{movie_id}/edit/{server_id}', 'Backend\MovieServesController@form')->name('admin.tv_series.servers.edit')->where('movie_id', '[0-9]+')->where('server_id', '[0-9]+');
    
    Route::post('/{movie_id}/save', 'Backend\MovieServesController@save')->name('admin.movies.servers.save')->where('movie_id', '[0-9]+');
    
    Route::post('/{movie_id}/remove', 'Backend\MovieServesController@remove')->name('admin.tv_series.servers.remove')->where('movie_id', '[0-9]+');
});

Route::group(['prefix' => 'tv-series/servers/upload'], function () {
    Route::get('/{server_id}', 'Backend\MovieUploadController@index')->name('admin.tv_series.servers.upload')->where('server_id', '[0-9]+');
    
    Route::get('/{server_id}/getdata', 'Backend\MovieUploadController@getData')->name('admin.tv_series.servers.upload.getdata')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/save', 'Backend\MovieUploadController@save')->name('admin.tv_series.servers.upload.save')->where('server_id', '[0-9]+');
    
    Route::post('/{server_id}/remove', 'Backend\MovieUploadController@remove')->name('admin.tv_series.servers.upload.remove')->where('server_id', '[0-9]+');
    
    Route::get('/get-file', 'Backend\MovieUploadController@getFile')->name('admin.movies.tv_series.upload.getfile');
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

Route::group(['prefix' => 'themes'], function () {
    Route::get('/', 'Backend\Theme\ThemesController@index')->name('admin.theme.themes');
    
    Route::post('/save', 'Backend\Theme\ThemesController@save')->name('admin.theme.themes.save');
});

Route::group(['prefix' => 'theme/menu'], function () {
    Route::get('/', 'Backend\Theme\MenuController@index')->name('admin.theme.menu');
    
    Route::post('/save', 'Backend\Theme\MenuController@save')->name('admin.theme.menu.save');
});

Route::group(['prefix' => 'theme/editor'], function () {
    Route::get('/', 'Backend\Theme\ThemeEditorController@index')->name('admin.theme.editor');
    
    Route::post('/save', 'Backend\Theme\ThemeEditorController@save')->name('admin.theme.editor.save');
});

Route::group(['prefix' => 'setting/system'], function () {
    Route::get('/', 'Backend\Setting\SystemSettingController@index')->name('admin.setting');
    
    Route::post('/save', 'Backend\Setting\SystemSettingController@save')->name('admin.setting.save');
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

Route::group(['prefix' => 'setting/languages'], function () {
    Route::get('/', 'Backend\Setting\LanguagesController@index')->name('admin.setting.languages');
    
    Route::get('/getdata', 'Backend\Setting\LanguagesController@getData')->name('admin.setting.languages.getdata');
    
    Route::post('/save', 'Backend\Setting\LanguagesController@save')->name('admin.setting.languages.save');
    
    Route::post('/remove', 'Backend\Setting\LanguagesController@remove')->name('admin.setting.languages.remove');
    
    Route::post('/sync', 'Backend\Setting\LanguagesController@syncLanguage')->name('admin.setting.languages.sync');
    
    Route::post('/set-default', 'Backend\Setting\LanguagesController@setDefault')->name('admin.setting.languages.default');
});

Route::group(['prefix' => 'setting/translate'], function () {
    Route::get('/{lang}', 'Backend\Setting\TranslateController@index')->name('admin.setting.translate')->where('lang', '[a-z]+');
    
    Route::get('/{lang}/getdata', 'Backend\Setting\TranslateController@getData')->name('admin.setting.translate.getdata')->where('lang', '[a-z]+');
    
    Route::post('/{lang}/save', 'Backend\Setting\TranslateController@save')->name('admin.setting.translate.save')->where('lang', '[a-z]+');
});

Route::group(['prefix' => 'setting/video-qualities'], function () {
    Route::get('/', 'Backend\Setting\VideoQualityController@index')->name('admin.video_qualities');
    
    Route::get('/getdata', 'Backend\Setting\VideoQualityController@getData')->name('admin.video_qualities.getdata');
    
    Route::get('/create', 'Backend\Setting\VideoQualityController@form')->name('admin.video_qualities.create');
    
    Route::get('/edit/{id}', 'Backend\Setting\VideoQualityController@form')->name('admin.video_qualities.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\VideoQualityController@save')->name('admin.video_qualities.save');
    
    Route::post('/remove', 'Backend\Setting\VideoQualityController@remove')->name('admin.video_qualities.remove');
});

Route::group(['prefix' => 'setting/ads'], function () {
    Route::get('/', 'Backend\Setting\AdsSettingController@index')->name('admin.setting.ads');
    
    Route::get('/getdata', 'Backend\AdsSettingController@getData')->name('admin.setting.ads.getdata');
    
    Route::get('/create', 'Backend\AdsSettingController@form')->name('admin.setting.ads.create');
    
    Route::get('/edit/{id}', 'Backend\AdsSettingController@form')->name('admin.setting.ads.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\AdsSettingController@save')->name('admin.setting.ads.save');
});

Route::group(['prefix' => 'setting/video-ads'], function () {
    Route::get('/', 'Backend\Setting\VideoAdsController@index')->name('admin.setting.video_ads');
    
    Route::get('/getdata', 'Backend\Setting\VideoAdsController@getData')->name('admin.setting.video_ads.getdata');
    
    Route::get('/create', 'Backend\Setting\VideoAdsController@form')->name('admin.setting.video_ads.create');
    
    Route::get('/edit/{id}', 'Backend\Setting\VideoAdsController@form')->name('admin.setting.video_ads.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\VideoAdsController@save')->name('admin.setting.video_ads.save');
    
    Route::post('/remove', 'Backend\Setting\VideoAdsController@remove')->name('admin.setting.video_ads.remove');
});

Route::group(['prefix' => 'setting/seo'], function () {
    Route::get('/', 'Backend\Setting\SeoSettingController@index')->name('admin.setting.seo');
    
    Route::post('/save', 'Backend\Setting\SeoSettingController@save')->name('admin.setting.seo.save');
});

Route::group(['prefix' => 'notification'], function () {
    Route::get('/', 'Backend\SendNotificationController@index')->name('admin.notification');
    
    Route::get('/getdata', 'Backend\SendNotificationController@getData')->name('admin.notification.getdata');
    
    Route::get('/create', 'Backend\SendNotificationController@form')->name('admin.notification.create');
    
    Route::get('/edit/{id}', 'Backend\SendNotificationController@form')->name('admin.notification.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\SendNotificationController@save')->name('admin.notification.save');
    
    Route::post('/remove', 'Backend\SendNotificationController@remove')->name('admin.notification.remove');
});