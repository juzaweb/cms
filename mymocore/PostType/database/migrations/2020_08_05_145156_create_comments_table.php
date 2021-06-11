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
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->string('email', 150)->index();
            $table->string('name')->nullable();
            $table->string('website')->nullable();
            $table->string('content', 300);
            $table->unsignedBigInteger('object_id')->index()->comment('Post type ID');
            $table->string('object_type', 50)->index()->comment('Post type');
            $table->string('status', 50)->default('pending');
            $table->timestamps();
            $table->unique([
                'user_id',
                'object_id',
                'object_type'
            ]);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
