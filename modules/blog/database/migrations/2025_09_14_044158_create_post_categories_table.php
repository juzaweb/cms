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
        Schema::create('post_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();
            $table->datetimes();

            $table->foreign('parent_id')
                ->references('id')
                ->on('post_categories')
                ->onDelete('cascade');
        });

        Schema::create('post_category_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('slug', 190)->unique();
            $table->string('locale', 5)->index();
            $table->uuid('post_category_id');
            $table->datetimes();

            $table->unique(['post_category_id', 'locale']);
            $table->foreign('post_category_id')
                ->references('id')
                ->on('post_categories')
                ->onDelete('cascade');
        });

        Schema::create('post_category', function (Blueprint $table) {
            $table->uuid('post_id');
            $table->uuid('post_category_id');
            $table->primary(['post_id', 'post_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_category');
        Schema::dropIfExists('post_category_translations');
        Schema::dropIfExists('post_categories');
    }
};
