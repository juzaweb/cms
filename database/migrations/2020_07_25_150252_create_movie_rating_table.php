<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieRatingTable extends Migration
{
    public function up()
    {
        Schema::create('movie_rating', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('movie_id')->index();
            $table->string('client_ip', 50)->index();
            $table->float('start');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('movie_rating');
    }
}
