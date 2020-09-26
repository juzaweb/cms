<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeechMoviesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('leech_movies')) {
            return false;
        }
        
        Schema::create('leech_movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('leech_link_id')->index();
            $table->longText('data');
            $table->tinyInteger('type')->default(1)->comment('1: movie, 2: tv series');
            $table->text('error')->nullable();
            $table->tinyInteger('status')->default(2)->comment('0: Failed, 1: Success, 2: Pending, 3: Downloading');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        //Schema::dropIfExists('leech_movies');
    }
}
