<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlerLinksTable extends Migration
{
    public function up()
    {
        Schema::create(
            'crawler_links',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('url', 300);
                $table->unsignedBigInteger('template_id')->index();
                $table->unsignedBigInteger('page_id')->nullable()->index();
                $table->json('category_ids')->nullable();
                $table->string('status', 10)->default('active');
                $table->json('error')->nullable();
                $table->unique(['url', 'template_id']);
                $table->timestamps();

                $table->foreign('template_id')
                    ->references('id')
                    ->on('crawler_templates')
                    ->onDelete('cascade');

                $table->foreign('page_id')
                    ->references('id')
                    ->on('crawler_pages')
                    ->onDelete('set null');
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('crawler_links');
    }
}
