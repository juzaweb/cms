<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('movie_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('movie_id')->index();
            $table->text('content');
            $table->tinyInteger('approved')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('movie_comments');
    }
}
