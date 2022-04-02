<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create(
            'subscription_histories',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('token', 100)->unique();
                $table->string('method', 50)->index();
                $table->string('agreement_id');
                $table->decimal('amount', 15, 2);
                $table->string('module', 50)->index();
                $table->string('payer_id')->nullable();
                $table->string('payer_email')->nullable();

                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->unsignedBigInteger('package_id')->index();
                $table->unsignedBigInteger('object_id')
                    ->nullable()
                    ->index();
                
                $table->timestamps();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');

                $table->foreign('package_id')
                    ->references('id')
                    ->on('packages');
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('subscription_histories');
    }
}
