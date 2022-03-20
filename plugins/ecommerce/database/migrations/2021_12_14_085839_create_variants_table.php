<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'variants',
            function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->decimal('price', 15, 2)->nullable();
                $table->decimal('compare_price', 15, 2)->nullable();
                $table->string('sku_code', 100)->nullable()->index();
                $table->string('barcode', 100)->nullable()->index();
                $table->json('images')->nullable();
                $table->json('names')->nullable();
                $table->bigInteger('quantity')->default(0);
                $table->unsignedBigInteger('product_id')->index();

                $table->foreign('product_id')
                    ->references('id')
                    ->on('posts')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('variants');
    }
}
