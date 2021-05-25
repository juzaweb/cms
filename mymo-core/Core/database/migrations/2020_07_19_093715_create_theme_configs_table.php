<?php

use Mymo\Core\Models\ThemeConfigs;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemeConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('theme_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 150)->unique()->index();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
        
        $this->_createConfigs();
    }
    
    public function down()
    {
        Schema::dropIfExists('theme_configs');
    }
    
    private function _createConfigs() {
        $configs = [
            'header' => '{"code":"header","site_header":{"code":"site_header"},"main_menu":{"code":"main_menu","menu":{"menu":"1"}}}',
            'home_page' => '{"code":"home_page","slider":{"code":"slider","status":"0"},"slider_movies":{"code":"slider_movies","status":"1","genre":{"title":"Latest movies","ctype":"1","format":null,"order":"updated_at_DESC","limit":"12"}},"genre1":{"code":"genre1","status":"1","genre":{"title":"Action","ctype":"1","genre":"1","format":null,"order":"updated_at_DESC","limit":"12"},"child_genres":["2","3","4"]},"genre2":{"code":"genre2","status":"1","genre":{"title":"Adventure","ctype":"1","genre":"2","format":null,"order":"updated_at_DESC","limit":"12"},"child_genres":["9","8","10"]},"genre3":{"code":"genre3","status":"1","genre":{"title":"Animation","ctype":"1","genre":"6","format":null,"order":"updated_at_DESC","limit":"12"},"child_genres":["3","2"]}}',
            'footer' => '{"code":"footer","column1":{"code":"column1","logo":"2020\/08\/15\/logo-1597464831-Z4tc4jsTu6.png","description":"MYMO is a powerful, flexible and User friendly TV Series & Movie Portal CMS with advance video contents management system. It\u2019s easy to use & install. It has been created to provide a unique experience to movie lover & movie site owner."},"column2":{"code":"column2","column":{"title":"Custom Link","ctype":"1","menu":"2","body":null}},"column3":{"code":"column3","column":{"title":"Custom Link","ctype":"1","menu":"2","body":null}}}',
            'sidebar' => '{"code":"sidebar","widget1":{"code":"widget1","status":"0","body":null},"popular_movies":{"code":"popular_movies","status":"1","title":"POPULAR","showpost":"10"},"widget2":{"code":"widget2","status":"0","body":null},"widget3":{"code":"widget3","status":"0","body":null}}',
        ];
        
        foreach ($configs as $key => $config) {
            ThemeConfigs::create([
                'code' => $key,
                'content' => $config,
            ]);
        }
    }
}
