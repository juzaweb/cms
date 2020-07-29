<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->string('name', 50);
            $table->text('body')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
        
        DB::table('ads')->insert([
            [
                'key' => 'home_header',
                'name' => 'Home Page Header',
            ],
            [
                'key' => 'genre_header',
                'name' => 'Genre Page Header',
            ],
            [
                'key' => 'sidebar',
                'name' => 'Sidebar',
            ],
            [
                'key' => 'player_bottom',
                'name' => 'Player Bottom',
            ]
        ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
