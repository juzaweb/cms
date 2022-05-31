<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'jw_translations',
            function (Blueprint $table) {
                $table->collation = 'utf8mb4_bin';
                $table->bigIncrements('id');
                $table->integer('status')->index()->default(1);
                $table->string('locale', 50)->index();
                $table->string('group', 50)->index();
                $table->string('namespace', 50)->index();
                $table->text('key');
                $table->text('value')->nullable();
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
        Schema::drop('jw_translations');
    }
}
