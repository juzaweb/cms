<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingAddressTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name', 250);
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('province', 150)->nullable();
            $table->string('country_code', 15)->nullable();
            $table->bigInteger('address_id')->nullable();
            $table->bigInteger('order_id')->index();
            $table->bigInteger('shop_id')->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('shipping_address');
    }
}
