<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create(
            'menus',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 100);
                $table->string('description')->nullable();
                $table->timestamps();
            }
        );
        
        Schema::create(
            'menu_items',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('menu_id');
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->string('box_key', 50);
                $table->string('label', 100);
                $table->string('model_class', 100)->index()->nullable();
                $table->bigInteger('model_id')->index()->nullable();
                $table->string('link')->nullable();
                $table->string('icon')->nullable();
                $table->string('target', 10)->default('_self');
                $table->integer('num_order')->index();
            
                $table->foreign('menu_id')
                    ->references('id')
                    ->on('menus')
                    ->onDelete('cascade');
                $table->foreign('parent_id')
                    ->references('id')
                    ->on('menu_items')
                    ->onDelete('cascade');
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
    }
}
