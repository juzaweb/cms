<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoQualitiesTable extends Migration
{
    public function up()
    {
        Schema::create('video_qualities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->tinyInteger('default')->default(0);
            $table->timestamps();
        });
        
        DB::table('video_qualities')->insert([
            [
                'name' => '4K',
                'default' => 0,
            ],
            [
                'name' => 'HD',
                'default' => 1,
            ],
            [
                'name' => 'SD',
                'default' => 0,
            ],
            [
                'name' => 'Cam',
                'default' => 0,
            ]
        ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('video_qualities');
    }
}
