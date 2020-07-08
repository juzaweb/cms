<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailListTable extends Migration
{
    public function up()
    {
        Schema::create('email_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emails', 300);
            $table->string('params', 300)->nullable();
            $table->string('title', 300);
            $table->string('template', 300);
            $table->text('error')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mail_list');
    }
}
