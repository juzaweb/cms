<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoQualitiesTable extends Migration
{
    public function up()
    {
        Schema::create('video_qualities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('video_qualities');
    }
}
