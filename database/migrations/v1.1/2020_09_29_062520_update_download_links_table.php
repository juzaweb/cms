<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDownloadLinksTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('download_links');
        Schema::table('download_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label', 250);
            $table->text('url');
            $table->integer('order')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('movie_id')->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('download_links');
    }
}
