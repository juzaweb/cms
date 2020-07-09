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
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('video_files');
    }
}
