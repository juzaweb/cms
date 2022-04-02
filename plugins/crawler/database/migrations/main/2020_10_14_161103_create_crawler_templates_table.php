<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlerTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create(
            'crawler_templates',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->text('crawler_thumbnail')->nullable();
                $table->text('crawler_title')->nullable();
                $table->text('crawler_content')->nullable();
                $table->string('lang', 5)->nullable();
                $table->boolean('auto_leech')->default(0);
                $table->string('status', 10)->default('active');
                $table->string('post_status', 10)->default('publish');
                $table->unsignedBigInteger('user_id')->index();
                $table->timestamps();
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('crawler_templates');
    }
}
