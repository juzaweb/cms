<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 250);
            $table->string('title_en', 250);
            $table->string('slug', 150)->unique()->index();
            $table->text('description')->nullable();
            $table->string('stars', 250)->nullable();
            $table->string('directors', 250)->nullable();
            $table->string('writers', 250)->nullable();
            $table->string('rating', 250)->nullable();
            $table->string('release', 25)->nullable();
            $table->string('countries', 250)->nullable();
            $table->string('genres', 250)->nullable();
            $table->string('runtime', 100)->nullable();
            $table->string('video_quality', 100)->nullable();
            $table->string('trailer_link', 100)->nullable();
            $table->integer('current_episode')->nullable();
            $table->integer('max_episode')->nullable();
            $table->tinyInteger('is_paid')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
