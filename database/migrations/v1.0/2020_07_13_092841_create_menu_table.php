<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->text('content');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
