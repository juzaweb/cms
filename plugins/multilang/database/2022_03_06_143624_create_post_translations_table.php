<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'post_translations',
            function (Blueprint $table) {
                $table->id();
                $table->string('title', 250);
                $table->string('thumbnail', 250)->nullable();
                $table->string('slug', 150)->unique();
                $table->string('description', 200)->nullable();
                $table->longText('content')->nullable();
                $table->string('locale', 5)->index();
                $table->unsignedBigInteger('post_id')->index();
                $table->unique(['locale', 'post_id']);
                $table->timestamps();

                $table->foreign('post_id')
                    ->references('id')
                    ->on('posts')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_translations');
    }
}
