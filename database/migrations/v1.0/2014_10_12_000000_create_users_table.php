<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('is_admin')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->string('language', 5)->default('en');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
