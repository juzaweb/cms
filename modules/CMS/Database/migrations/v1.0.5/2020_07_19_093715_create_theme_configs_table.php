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
            $table->string('code', 50)->index();
            $table->string('theme', 150)->index();
            $table->text('value')->nullable();
            $table->unique(['code', 'theme']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('theme_configs');
    }
}
