<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveTvCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('live_tv_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thumbnail', 150)->nullable();
            $table->string('name', 250);
            $table->text('description')->nullable();
            $table->string('slug', 150)->unique()->index();
            $table->tinyInteger('status')->default(1);
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('keywords', 320)->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('live_tv_categories');
    }
}
