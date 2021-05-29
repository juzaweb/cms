<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomiesTable extends Migration
{
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 100)->index();
            $table->string('taxonomy', 100)->index();
            $table->bigInteger('parent_id')->nullable()->index();
            $table->bigInteger('total_post')->default(0);
            $table->bigInteger('created_by')->nullable()->index();
            $table->bigInteger('updated_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('taxonomy_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('taxonomy_id');
            $table->string('locale', 5)->index();
            $table->string('name', 200);
            $table->string('thumbnail', 150)->nullable();
            $table->text('description')->nullable();
            $table->string('slug', 100)->unique();

            $table->unique(['taxonomy_id', 'locale']);
            $table->foreign('taxonomy_id')
                ->references('id')
                ->on('taxonomies')
                ->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('taxonomy_translations');
        Schema::dropIfExists('taxonomies');
    }
}
