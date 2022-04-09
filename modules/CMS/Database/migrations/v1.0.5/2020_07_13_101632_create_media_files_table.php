<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaFilesTable extends Migration
{
    public function up()
    {
        Schema::create('media_files', function (Blueprint $table) {
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
        });
        
        //$this->_createFiles();
    }
    
    public function down()
    {
        Schema::dropIfExists('media_files');
    }
    
    private function _createFiles() {
        DB::table('files')->insert([
            [
                'name' => 'logo.png',
                'type' => 1,
                'mime_type' => 'image/png',
                'path' => '2020/08/15/logo-1597464831-Z4tc4jsTu6.png',
                'extension' => 'png',
                'size' => 8741,
                'folder_id' => null,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'icon.png',
                'type' => 1,
                'mime_type' => 'image/png',
                'path' => '2020/08/15/icon-1597477743-dkiMRD8xpZ.png',
                'extension' => 'png',
                'size' => 20047,
                'folder_id' => null,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'banner.png',
                'type' => 1,
                'mime_type' => 'image/png',
                'path' => '2020/08/15/banner-juzaweb-1597477743-EHZ3staOHI.png',
                'extension' => 'png',
                'size' => 94892,
                'folder_id' => null,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
