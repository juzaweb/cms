<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token', 100)->unique();
            $table->string('role', 50);
            $table->string('method', 50);
            $table->string('agreement_id');
            $table->string('payer_id');
            $table->string('payer_email');
            $table->decimal('amount', 15, 2);
            $table->bigInteger('user_id')->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
}
