<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('order_items');
    }
}
