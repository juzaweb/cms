<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMoviesTable extends Migration
{
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->tinyInteger('paid')->default(0);
        });
    }
    
    public function down()
    {
    
    }
}
