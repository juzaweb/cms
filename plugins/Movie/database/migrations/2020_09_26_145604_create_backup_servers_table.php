<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupServersTable extends Migration
{
    public function up()
    {
        Schema::create('backup_servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->text('data');
            $table->string('server', 50);
            $table->tinyInteger('order')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('backup_servers');
    }
}
