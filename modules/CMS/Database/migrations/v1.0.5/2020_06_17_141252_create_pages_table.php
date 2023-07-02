<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 250);
            $table->string('thumbnail', 250)->nullable();
            $table->string('slug', 150)->unique();
            $table->string('template', 50)->index()->nullable();
            $table->longText('content')->nullable();
            $table->longText('template_data')->nullable();
            $table->string('status', 50)->index()->default('draft');
            $table->bigInteger('views')->default(0);
            $table->timestamps();
        });

        Schema::create('page_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page_id')->index();
            $table->string('meta_key', 150)->index();
            $table->text('meta_value')->nullable();
            $table->unique(['page_id', 'meta_key']);

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_metas');
        Schema::dropIfExists('pages');
    }

    private function _createPages()
    {
        $pages = [
            'Terms of Use',
            'Privacy Policy',
        ];

        foreach ($pages as $page) {
            Page::create([
                'name' => $page,
                'slug' => \Illuminate\Support\Str::slug($page),
                'content' => $page . ' demo page',
            ]);
        }
    }
}
