<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('backup_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('video_file_id')->index();
            $table->bigInteger('backup_server_id')->index();
            $table->text('error')->nullable();
            $table->timestamps();
            $table->unique(['video_file_id', 'backup_server_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('backup_histories');
    }
}
