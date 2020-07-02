<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStarsTable extends Migration
{
    public function up()
    {
        Schema::create('stars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('description', 300)->nullable();
            $table->string('thumbnail', 250)->nullable();
            $table->string('slug', 150)->unique()->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('stars');
    }
}
