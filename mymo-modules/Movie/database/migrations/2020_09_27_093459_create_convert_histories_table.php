<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvertHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('convert_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('video_file_id')->unique()->index();
            $table->text('error')->nullable();
            $table->tinyInteger('status')->default(2)
                ->comment('1: ok, 0: error, 2: converting');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('convert_histories');
    }
}
