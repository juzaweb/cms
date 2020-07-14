<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailListTable extends Migration
{
    public function up()
    {
        Schema::create('email_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emails', 300);
            $table->string('subject', 300);
            $table->text('content');
            $table->text('params')->nullable();
            $table->text('error')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1: sended, 2: pending, 3: cancel, 0: error');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('email_list');
    }
}
