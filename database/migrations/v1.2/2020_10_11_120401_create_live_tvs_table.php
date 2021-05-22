<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveTvsTable extends Migration
{
    public function up()
    {
        Schema::create('live_tvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('poster')->nullable();
            $table->bigInteger('category_id')->index();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_paid')->default(0);
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('keywords', 320)->nullable();
            $table->text('tags')->nullable();
            $table->bigInteger('views')->default(0);
            $table->string('slug', 150)->unique();
            $table->bigInteger('created_by')->index();
            $table->bigInteger('updated_by')->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('live_tvs');
    }
}
