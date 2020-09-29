<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadLinksTable extends Migration
{
    public function up()
    {
        Schema::create('download_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('download_links');
    }
}
