<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'video_ads',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 50);
                $table->string('title')->nullable();
                $table->string('url')->nullable();
                $table->string('video')->nullable();
                $table->string('position');
                $table->integer('offset')->default(1);
                $table->json('options')->nullable();
                $table->boolean('active')->default(1)->index();
                $table->bigInteger('views')->default(0);
                $table->bigInteger('click')->default(0);
                $table->datetimes();
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
        Schema::dropIfExists('video_ads');
    }
};
