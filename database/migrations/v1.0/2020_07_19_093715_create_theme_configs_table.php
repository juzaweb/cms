<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemeConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('theme_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 150)->unique()->index();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('theme_configs');
    }
}
