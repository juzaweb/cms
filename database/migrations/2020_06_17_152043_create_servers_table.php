<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stream_key', 100)->unique()->index();
            $table->string('name', 100);
            $table->string('source_type', 100);
            $table->string('file_source', 100);
            $table->text('file_url');
            $table->integer('order')->default(1);
            $table->bigInteger('movie_id')->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
