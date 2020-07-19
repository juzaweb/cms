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
        
        Configs::setConfig('title', 'MyMo');
        Configs::setConfig('description', '');
        Configs::setConfig('logo', '');
        Configs::setConfig('icon', '');
        Configs::setConfig('banner', '');
        Configs::setConfig('user_registration', 1);
        Configs::setConfig('user_verification', 0);
        Configs::setConfig('google_recaptcha', 0);
        Configs::setConfig('google_recaptcha_key', '');
        Configs::setConfig('google_recaptcha_secret', '');
        Configs::setConfig('comment_able', 1);
        Configs::setConfig('comment_type', 'facebook');
        Configs::setConfig('comments_per_page', 10);
        Configs::setConfig('comments_approval', 'auto');
    }
    
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
