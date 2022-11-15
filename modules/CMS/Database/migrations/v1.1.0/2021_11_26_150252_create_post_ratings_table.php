<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostRatingsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'post_ratings',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('post_id')->index();
                $table->string('client_ip', 50)->index();
                $table->float('star');
                $table->timestamps();

                $table->foreign('post_id')
                    ->references('id')
                    ->on('posts')
                    ->onDelete('cascade');
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('post_ratings');
    }
}
