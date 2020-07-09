<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoAdsTable extends Migration
{
    public function up()
    {
        Schema::create('video_ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('title', 250);
            $table->string('url', 250);
            $table->string('description', 350)->nullable();
            $table->string('video_url', 250);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('video_ads');
    }
}
