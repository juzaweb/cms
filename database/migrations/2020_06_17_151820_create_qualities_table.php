<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualitiesTable extends Migration
{
    public function up()
    {
        Schema::create('qualities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('description', 200);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qualities');
    }
}
