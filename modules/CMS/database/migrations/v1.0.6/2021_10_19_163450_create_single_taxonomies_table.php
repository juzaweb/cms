<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingleTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_taxonomies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200);
            $table->string('thumbnail', 150)->nullable();
            $table->text('description')->nullable();
            $table->string('slug', 100)->unique();
            $table->string('post_type', 50)->index();
            $table->unsignedBigInteger('post_id')->index();
            $table->string('taxonomy', 50)->index();
            $table->bigInteger('total_post')->default(0);
            $table->timestamps();
            $table->unique(['post_type', 'post_id']);
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
        });

        Schema::create('taxonomy_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('taxonomy_id')->index();
            $table->string('meta_key', 150)->index();
            $table->text('meta_value')->nullable();
            $table->unique(['taxonomy_id', 'meta_key']);

            $table->foreign('taxonomy_id')
                ->references('id')
                ->on('taxonomies')
                ->onDelete('cascade');
        });

        Schema::create('single_taxonomy_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('taxonomy_id')->index();
            $table->string('meta_key', 150)->index();
            $table->text('meta_value')->nullable();
            $table->unique(['taxonomy_id', 'meta_key']);

            $table->foreign('taxonomy_id')
                ->references('id')
                ->on('single_taxonomies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('single_taxonomy_metas');
        Schema::dropIfExists('single_taxonomies');
        Schema::dropIfExists('taxonomy_metas');
    }
}
