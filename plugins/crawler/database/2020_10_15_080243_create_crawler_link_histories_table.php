<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlerLinkHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('crawler_link_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('link_id')->index();
            $table->text('error')->nullable();
            $table->tinyInteger('status')->default(2);
            $table->string('date', 10);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('crawler_link_histories');
    }
}
