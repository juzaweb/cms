<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'manual_notifications',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('method', 150)->index()->nullable();
                $table->text('users');
                $table->text('data');
                $table->tinyInteger('status')->default(2);
                $table->text('error')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('manual_notifications');
    }
}
