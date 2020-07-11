<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Translation;

class CreateTranslationTable extends Migration
{
    public function up()
    {
        Schema::create('translation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 150)->unique();
            $table->string('en', 300)->nullable();
            $table->timestamps();
        });
    
        Translation::syncLanguage();
    }
    
    public function down()
    {
        Schema::dropIfExists('translation');
    }
}
