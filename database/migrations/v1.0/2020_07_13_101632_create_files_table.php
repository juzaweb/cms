<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->tinyInteger('type')->default(1)->comment('1: images, 2: files');
            $table->string('mime_type');
            $table->string('path');
            $table->string('extension');
            $table->bigInteger('size')->default(0);
            $table->bigInteger('folder_id')->index()->nullable();
            $table->bigInteger('user_id')->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
