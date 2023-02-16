<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaFoldersTable extends Migration
{
    public function up()
    {
        Schema::create(
            'media_folders',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('type', 50)->default('image');
                $table->bigInteger('folder_id')->index()->nullable();
                $table->timestamps();
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('media_folders');
    }
}
