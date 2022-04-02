<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create(
            'user_subscriptions',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('module', 50)->index();
                $table->string('method', 50)->index();
                $table->string('agreement_id');
                $table->decimal('amount', 15, 2);
                $table->date('next_payment');
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedBigInteger('package_id')
                    ->nullable()
                    ->index();

                $table->unique(['user_id', 'module']);
                $table->timestamps();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

                $table->foreign('package_id')
                    ->references('id')
                    ->on('packages')
                    ->onDelete('cascade');
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
}
