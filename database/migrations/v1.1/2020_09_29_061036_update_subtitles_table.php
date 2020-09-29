<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubtitlesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('subtitles');
        Schema::create('subtitles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label', 250);
            $table->text('url');
            $table->integer('order')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('video_file_id')->index();
            $table->bigInteger('movie_id')->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('subtitles');
    }
}
