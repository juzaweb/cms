<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->string('type', 50)->index();
            $table->string('thumbnail', 150)->nullable();
            $table->string('description', 200)->nullable();
            $table->json('json_metas')->nullable();
            $table->string('status', 50)->index()->default('publish');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->foreign('parent_id')
                ->references('id')
                ->on('resources')
                ->onDelete('cascade');
        });

        Schema::create('resource_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('resource_id')->index();
            $table->string('meta_key', 150)->index();
            $table->text('meta_value')->nullable();
            $table->unique(['resource_id', 'meta_key']);

            $table->foreign('resource_id')
                ->references('id')
                ->on('resources')
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
        Schema::dropIfExists('resource_metas');
        Schema::dropIfExists('resources');
    }
}
