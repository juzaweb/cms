<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieViewsTable extends Migration
{
    public function up()
    {
        Schema::create('movie_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('movie_id')->index();
            $table->bigInteger('views')->default(0);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('movie_views');
    }
}
