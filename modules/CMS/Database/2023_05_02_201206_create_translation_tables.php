<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'post_translations',
            function (Blueprint $table) {
                $table->id();
                $table->string('title', 250);
                $table->string('thumbnail', 250)->nullable();
                $table->string('slug', 150)->unique();
                $table->string('description', 200)->nullable();
                $table->longText('content')->nullable();
                $table->string('locale', 5)->index();
                $table->unsignedBigInteger('post_id')->index();
                $table->unique(['post_id', 'locale']);
                $table->timestamps();
            }
        );

        Schema::create(
            'taxonomy_translations',
            function (Blueprint $table) {
                $table->id();
                $table->string('name', 200);
                $table->string('thumbnail', 150)->nullable();
                $table->text('description')->nullable();
                $table->string('slug', 100)->unique();
                $table->string('locale', 5)->index();
                $table->unsignedBigInteger('post_id')->index();
                $table->unique(['post_id', 'locale']);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('post_translations');
    }
};
