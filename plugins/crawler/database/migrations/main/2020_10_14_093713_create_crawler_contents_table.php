<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlerContentsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'crawler_contents',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('url', 300)->index();
                $table->string('thumbnail', 200)->nullable();
                $table->json('components');
                $table->string('lang', 5)->nullable()->index();
                $table->unsignedBigInteger('template_id')->index();
                $table->unsignedBigInteger('link_id')->index()->unique();
                $table->unsignedBigInteger('page_id')->index();
                $table->json('category_ids')->nullable();
                $table->text('crawler_thumbnail')->nullable();
                $table->text('crawler_title')->nullable();
                $table->text('crawler_content')->nullable();
                $table->string('status')->default('active');
                $table->timestamps();
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('crawler_contents');
    }
}
