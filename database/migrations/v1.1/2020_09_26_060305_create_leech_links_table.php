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
            $table->tinyInteger('tv_series')->default(0);
            $table->tinyInteger('leech_data')->default(2)
                ->comment('0: error, 1: success, 2: pending, 3: leeching');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('leech_links');
    }
}
