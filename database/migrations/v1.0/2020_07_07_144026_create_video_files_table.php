<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoFilesTable extends Migration
{
    public function up()
    {
        Schema::create('video_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('server_id')->index();
            $table->bigInteger('movie_id')->index();
            $table->string('label');
            $table->integer('order')->default(1);
            $table->string('source', 100);
            $table->string('url');
            $table->string('video_240p')->nullable();
            $table->string('video_360p')->nullable();
            $table->string('video_480p')->nullable();
            $table->string('video_720p')->nullable();
            $table->string('video_1080p')->nullable();
            $table->string('video_2048p')->nullable();
            $table->string('video_4096p')->nullable();
            $table->tinyInteger('converted')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('video_files');
    }
}
