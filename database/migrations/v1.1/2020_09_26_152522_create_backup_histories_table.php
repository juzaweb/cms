<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('backup_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('file_id')->index();
            $table->bigInteger('server_id')->index();
            $table->tinyInteger('type')->default(1)->comment('1: file, 2: leech');
            $table->text('error')->nullable();
            $table->timestamps();
            $table->unique(['file_id', 'server_id', 'type']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('backup_histories');
    }
}
