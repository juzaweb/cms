<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailListsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'email_lists',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('email', 150)->index();
                $table->unsignedBigInteger('template_id')->nullable()->index();
                $table->text('params')->nullable();
                $table->string('status', 50)
                    ->index()
                    ->default('pending')
                    ->comment('pending => processing => (success || error)');
                $table->integer('priority')->default(1);
                $table->text('error')->nullable();
                $table->text('data')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('email_lists');
    }
}
