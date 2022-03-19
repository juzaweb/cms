<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create(
            'orders',
            function (Blueprint $table) {
                $table->id();
                $table->uuid('key')->unique();
                $table->string('code', 10)->unique();
                $table->string('name', 250);
                $table->string('phone', 50)->nullable();
                $table->string('email', 150)->nullable();
                $table->text('address')->nullable();
                $table->string('country_code', 15)->nullable();
                $table->integer('quantity');
                $table->decimal('total_price', 20, 2);
                $table->decimal('total', 20, 2);
                $table->decimal('discount', 20, 2)->default(0);
                $table->string('discount_codes', 150)->nullable();
                $table->string('discount_target_type', 50)->nullable();
                $table->unsignedBigInteger('payment_method_id')->nullable()->index();
                $table->string('payment_method_name', 250);
                $table->text('notes')->nullable();
                $table->tinyInteger('other_address')->default(0);
                //$table->tinyInteger('status')->default(2)->comment('0: hủy, 1: đã thanh toán, 2: chưa thanh toán');
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->unsignedBigInteger('site_id')->nullable()->index();
                $table->timestamps();
                $table->unique(['code', 'site_id']);

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');

                $table->foreign('payment_method_id')
                    ->references('id')
                    ->on('payment_methods')
                    ->onDelete('set null');
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
