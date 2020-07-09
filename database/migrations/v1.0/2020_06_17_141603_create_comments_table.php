<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('subject_id')->index();
            $table->tinyInteger('type')->default(1)->index()->comment('1: movie / 2: post');
            $table->text('content');
            $table->tinyInteger('approved')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->unique(['user_id', 'subject_id', 'type']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
