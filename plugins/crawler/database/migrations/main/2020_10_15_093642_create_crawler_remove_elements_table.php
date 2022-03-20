<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlerRemoveElementsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'crawler_remove_elements',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('element');
                $table->integer('index')->nullable();
                $table->tinyInteger('type')
                    ->default(1)
                    ->comment('1: Remove all, 2: Remove html');
                $table->unsignedBigInteger('template_id')->index();

                $table->foreign('template_id')
                    ->references('id')
                    ->on('crawler_templates')
                    ->onDelete('cascade');
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('crawler_remove_elements');
    }
}
