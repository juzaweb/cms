<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlerTranslateHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('crawler_translate_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('content_id')->index();
            $table->bigInteger('post_id')->index()->nullable();
            $table->string('lang', 5)->index();
            $table->text('error')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('crawler_translate_histories');
    }
}
