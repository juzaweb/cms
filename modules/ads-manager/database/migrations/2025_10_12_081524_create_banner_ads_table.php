<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    public function up()
    {
        Schema::create(
            'banner_ads',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 50);
                $table->string('type', 50)->default('html');
                $table->text('body')->nullable();
                $table->text('url')->nullable();
                $table->boolean('active')->default(1)->index();
                $table->bigInteger('views')->default(0);
                $table->bigInteger('click')->default(0);
                $table->datetimes();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('banner_ads');
    }
};
