<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'taxonomy_translations',
            function (Blueprint $table) {
                $table->id();
                $table->string('name', 200);
                $table->string('thumbnail', 150)->nullable();
                $table->text('description')->nullable();
                $table->string('slug', 150)->unique();
                $table->string('locale', 5)->index();
                $table->timestamps();

                $table->unsignedBigInteger('taxonomy_id')->index();
                $table->unique(['locale', 'taxonomy_id']);

                $table->foreign('taxonomy_id')
                    ->references('id')
                    ->on('taxonomies')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomy_translations');
    }
}
