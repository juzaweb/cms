<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'juad_ads',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 50);
                $table->string('type', 50)->default('html');
                $table->string('position', 50);
                $table->text('body')->nullable();
                $table->boolean('active')->default(1);
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('juad_ads');
    }
}
