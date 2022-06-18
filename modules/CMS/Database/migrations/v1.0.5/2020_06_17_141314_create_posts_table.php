<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'posts',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title', 250);
                $table->string('thumbnail', 250)->nullable();
                $table->string('slug', 150)->unique();
                $table->string('description', 200)->nullable();
                $table->longText('content')->nullable();
                $table->string('status', 50)->index()->default('draft');
                $table->bigInteger('views')->default(0);
                $table->timestamps();
            }
        );

        Schema::create(
            'post_metas',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('post_id')->index();
                $table->string('meta_key', 150)->index();
                $table->text('meta_value')->nullable();
                $table->unique(['post_id', 'meta_key']);

                $table->foreign('post_id')
                    ->references('id')
                    ->on('posts')
                    ->onDelete('cascade');
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('post_metas');
        Schema::dropIfExists('posts');
    }
}
