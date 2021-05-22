<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveTvStreamsTable extends Migration
{
    public function up()
    {
        Schema::create('live_tv_streams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->string('from');
            $table->text('url');
            $table->integer('order')->default(1);
            $table->bigInteger('live_tv_id')->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('live_tv_streams');
    }
}
