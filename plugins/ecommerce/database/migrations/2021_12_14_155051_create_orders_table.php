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
                $table->uuid('code')->unique();
                $table->string('name', 150);
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
                $table->string('payment_status')->default('pending')->comment('pending');
                $table->string('delivery_status')->default('pending')->comment('pending');
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->timestamps();
                
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
    
        Schema::create(
            'order_items',
            function (Blueprint $table) {
                $table->id();
                $table->decimal('price', 15, 2);
                $table->decimal('compare_price', 15, 2)->nullable();
                $table->string('sku_code', 100)->nullable()->index();
                $table->string('barcode', 100)->nullable()->index();
                $table->unsignedBigInteger('order_id')->index();
                $table->unsignedBigInteger('product_id')->nullable()->index();
                $table->unsignedBigInteger('variant_id')->nullable()->index();
                $table->timestamps();
            
                $table->foreign('order_id')
                    ->references('id')
                    ->on('orders')
                    ->onDelete('cascade');
            
                $table->foreign('product_id')
                    ->references('id')
                    ->on('posts')
                    ->onDelete('set null');
            
                $table->foreign('variant_id')
                    ->references('id')
                    ->on('product_variants')
                    ->onDelete('set null');
            }
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}
