<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeechLinksTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('leech_links')) {
            return false;
        }
        
        Schema::create('leech_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 500);
            $table->text('link')->unique();
            $table->string('server');
            $table->tinyInteger('leech_data')->default(2);
            $table->tinyInteger('leech_link')->default(2);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        //Schema::dropIfExists('leech_links');
    }
}
