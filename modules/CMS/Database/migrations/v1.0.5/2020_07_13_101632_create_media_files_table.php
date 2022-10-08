<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    public function up()
    {
        Schema::create(
            'media_files',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('type', 50)->default('image');
                $table->string('mime_type');
                $table->string('path');
                $table->string('extension');
                $table->bigInteger('size')->default(0);
                $table->bigInteger('folder_id')->index()->nullable();
                $table->bigInteger('user_id')->index();
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('media_files');
    }
};
