<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyNotificationTable extends Migration
{
    public function up()
    {
        Schema::create('my_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->text('users')->nullable();
            $table->string('subject', 300);
            $table->text('content');
            $table->tinyInteger('type')->default(1)->comment('1: Notify, 2: Email, 3: All');
            $table->tinyInteger('status')->default(2)->comment('0: Cancel, 1: Sended, 2: Sending, 3: Pause');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('my_notification');
    }
}
