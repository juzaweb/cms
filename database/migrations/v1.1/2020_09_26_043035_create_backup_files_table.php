<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupFilesTable extends Migration
{
    public function up()
    {
        Schema::create('backup_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('video_file_id')->index();
            $table->bigInteger('backup_server_id')->index();
            $table->string('source', 100);
            $table->string('url');
            $table->string('video_240p')->nullable();
            $table->string('video_360p')->nullable();
            $table->string('video_480p')->nullable();
            $table->string('video_720p')->nullable();
            $table->string('video_1080p')->nullable();
            $table->string('video_2048p')->nullable();
            $table->string('video_4096p')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('backup_files');
    }
}
