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
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('object_id')->index();
            $table->string('object_type', 50)->index();
            $table->text('content');
            $table->string('status', 50)->default('');
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
