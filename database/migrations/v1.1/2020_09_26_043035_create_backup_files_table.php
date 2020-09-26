<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupFilesTable extends Migration
{
    public function up()
    {
        Schema::create('backup_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('backup_files');
    }
}
