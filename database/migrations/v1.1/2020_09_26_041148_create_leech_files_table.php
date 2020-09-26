<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeechFilesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('leech_files')) {
            return false;
        }
        
        Schema::create('leech_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('leech_id')->index();
            $table->string('label', 200);
            $table->text('original_url');
            $table->text('local_path')->nullable();
            $table->text('error')->nullable();
            $table->tinyInteger('status')->default(2)->comment('0: Download failed, 1: Download success, 2: Download pending, 3: Downloading');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        //Schema::dropIfExists('leech_files');
    }
}
