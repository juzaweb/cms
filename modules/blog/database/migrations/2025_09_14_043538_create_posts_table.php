<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status', 10)->default('draft');
            $table->bigInteger('views')->default(0);
            $table->creator();
            $table->datetimes();
        });

        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug', 190)->index();
            $table->longText('content')->nullable();
            $table->text('description')->nullable();
            $table->string('locale', 5)->index();
            $table->uuid('post_id');

            $table->unique(['slug']);
            $table->unique(['post_id', 'locale']);
            $table->datetimes();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_translations');
        Schema::dropIfExists('posts');
    }
};
