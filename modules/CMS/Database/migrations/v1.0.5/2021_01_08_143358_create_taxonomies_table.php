<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomiesTable extends Migration
{
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200);
            $table->string('thumbnail', 150)->nullable();
            $table->text('description')->nullable();
            $table->string('slug', 100)->unique();
            $table->string('post_type', 50)->index();
            $table->string('taxonomy', 50)->index();
            $table->bigInteger('parent_id')->nullable()->index();
            $table->bigInteger('total_post')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxonomies');
    }
}
