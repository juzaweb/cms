<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Configs;

class CreateConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 100)->unique();
            $table->string('value', 300)->nullable();
            $table->timestamps();
        });
        
        $this->_createConfig();
    }
    
    public function down()
    {
        Schema::dropIfExists('configs');
    }
    
    private function _createConfig() {
        Configs::setConfig('title', 'MyMo - TV Series & Movie Portal CMS');
        Configs::setConfig('description', 'MYMO is a powerful, flexible and User friendly TV Series & Movie Portal CMS with advance video contents management system. It’s easy to use & install. It has been created to provide a unique experience to movie lover & movie site owner.');
        Configs::setConfig('logo', '2020/08/15/logo-1597464831-Z4tc4jsTu6.png');
        Configs::setConfig('icon', '2020/08/15/icon-1597477743-dkiMRD8xpZ.png');
        Configs::setConfig('banner', '2020/08/15/banner-mymo-1597477743-EHZ3staOHI.png');
        Configs::setConfig('author_name', 'MyMo Team');
        Configs::setConfig('user_registration', 1);
        Configs::setConfig('user_verification', 0);
        Configs::setConfig('tmdb_api_key', '92b2df3080b91d92b31eacb015fc5497');
        Configs::setConfig('google_recaptcha', 0);
        Configs::setConfig('google_recaptcha_key', '');
        Configs::setConfig('google_recaptcha_secret', '');
        Configs::setConfig('comment_able', 0);
        Configs::setConfig('comment_type', 'facebook');
        Configs::setConfig('comments_per_page', 10);
        Configs::setConfig('comments_approval', 'auto');
        Configs::setConfig('movies_title', 'Movies');
        Configs::setConfig('tv_series_title', 'TV Series');
        Configs::setConfig('blog_title', 'Blog');
        Configs::setConfig('latest_movies_title', 'Latest movies');
        Configs::setConfig('facebook', '#');
        Configs::setConfig('twitter', '#');
        Configs::setConfig('pinterest', '#');
        Configs::setConfig('youtube', '#');
    }
}
