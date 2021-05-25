<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 15)->unique();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('default')->default(0);
            $table->timestamps();
        });
        
        DB::table('languages')->insert([
            'name' => 'English',
            'key' => 'en',
            'default' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
