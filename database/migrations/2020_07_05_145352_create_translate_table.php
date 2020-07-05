<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslateTable extends Migration
{
    public function up()
    {
        Schema::create('translate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 150)->unique();
            $table->string('en', 300)->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('translate');
    }
}
