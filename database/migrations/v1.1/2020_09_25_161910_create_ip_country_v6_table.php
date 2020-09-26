<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpCountryV6Table extends Migration
{
    public function up()
    {
        Schema::create('ip_countries_v6', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ip_countries_v6');
    }
}
