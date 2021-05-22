<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryNamesTable extends Migration
{
    public function up()
    {
        Schema::create('country_names', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 5)->unique();
            $table->string('name', 150);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('country_names');
    }
}
