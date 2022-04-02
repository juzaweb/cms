<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_id')->index();
            $table->string('method', 50);
            $table->string('agreement_id');
            $table->string('payer_id');
            $table->string('payer_email');
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('payment_histories');
    }
}
