<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Juzaweb\CMS\Facades\Config;

class CreateConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 100)->unique();
            $table->text('value')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configs');
    }

    private function _createConfig()
    {
        Config::setConfig('title', 'MyMo - TV Series & Movie Portal CMS');
        Config::setConfig('description', 'MYMO is a powerful, flexible and User friendly TV Series & Movie Portal CMS with advance video contents management system. It’s easy to use & install. It has been created to provide a unique experience to movie lover & movie site owner.');
        Config::setConfig('logo', '2020/08/15/logo-1597464831-Z4tc4jsTu6.png');
        Config::setConfig('icon', '2020/08/15/icon-1597477743-dkiMRD8xpZ.png');
        Config::setConfig('banner', '2020/08/15/banner-juzaweb-1597477743-EHZ3staOHI.png');
        Config::setConfig('author_name', 'MyMo Team');
        Config::setConfig('user_registration', 1);
        Config::setConfig('user_verification', 0);
        Config::setConfig('tmdb_api_key', '92b2df3080b91d92b31eacb015fc5497');
        Config::setConfig('google_recaptcha', 0);
        Config::setConfig('google_recaptcha_key', '');
        Config::setConfig('google_recaptcha_secret', '');
        Config::setConfig('comment_able', 0);
        Config::setConfig('comment_type', 'facebook');
        Config::setConfig('comments_per_page', 10);
        Config::setConfig('comments_approval', 'auto');
        Config::setConfig('movies_title', 'Movies');
        Config::setConfig('tv_series_title', 'TV Series');
        Config::setConfig('blog_title', 'Blog');
        Config::setConfig('latest_movies_title', 'Latest movies');
        Config::setConfig('facebook', '#');
        Config::setConfig('twitter', '#');
        Config::setConfig('pinterest', '#');
        Config::setConfig('youtube', '#');
    }
}
