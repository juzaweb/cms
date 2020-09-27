<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemoteHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('remote_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('video_file_id')->unique()->index();
            $table->text('error')->nullable();
            $table->tinyInteger('download_status')->default(2)
                ->comment('1: ok, 0: error, 2: downloading');
            $table->tinyInteger('upload_status')->default(2)
                ->comment('1: ok, 0: error, 2: pending, 3: uploading');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('remote_histories');
    }
}
