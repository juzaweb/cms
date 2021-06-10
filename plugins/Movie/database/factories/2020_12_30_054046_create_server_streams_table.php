<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerStreamsTable extends Migration
{
    public function up()
    {
        Schema::create('server_streams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 32)->unique();
            $table->string('name', 250);
            $table->string('base_url', 250);
            $table->tinyInteger('priority')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('server_streams');
    }
}
