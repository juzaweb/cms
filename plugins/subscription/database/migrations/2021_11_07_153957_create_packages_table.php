<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->uuid('key')->unique();
            $table->string('name', 50);
            $table->string('description', 200)->nullable();
            $table->decimal('price')->nullable();
            $table->integer('period')->default(1);
            $table->string('period_unit', 1)->default('m');
            $table->string('module', 50)->index();
            $table->json('data')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->boolean('is_free')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
