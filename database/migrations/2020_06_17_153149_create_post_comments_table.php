<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('movie_id')->index();
            $table->bigInteger('user_id')->index();
            $table->text('content');
            $table->timestamps();
            $table->unique(['movie_id', 'user_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
}
