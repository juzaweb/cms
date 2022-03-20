<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlerComponentReplacesTable extends Migration
{
    public function up()
    {
        Schema::create(
            'crawler_component_replaces',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('component_id')->index();
                $table->string('find', 300);
                $table->string('replace', 300);
                $table->tinyInteger('type')
                    ->default(1)
                    ->comment('1: str_replace, 2: preg_replace');
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('crawler_component_replaces');
    }
}
