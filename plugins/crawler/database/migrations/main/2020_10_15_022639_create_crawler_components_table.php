<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlerComponentsTable extends Migration
{
    public function up()
    {
        Schema::create('crawler_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('element');
            $table->string('attr')->nullable();
            $table->integer('index')->nullable();
            $table->unsignedBigInteger('template_id')->index();
            $table->tinyInteger('trans')->default(1);
            $table->unique(['code', 'template_id']);

            $table->foreign('template_id')
                ->references('id')
                ->on('crawler_templates')
                ->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('crawler_components');
    }
}
