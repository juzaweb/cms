<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'product_variants',
            function (Blueprint $table) {
                $table->id();
                $table->string('sku_code', 100)->nullable()->index();
                $table->string('barcode', 100)->nullable()->index();
                $table->string('title');
                $table->text('thumbnail')->nullable();
                $table->text('description')->nullable();
                $table->json('names')->nullable();
                $table->json('images')->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->decimal('compare_price', 15, 2)->nullable();
                $table->bigInteger('quantity')->default(0);
                $table->boolean('stock')->default(0);

                //Type: [default, downloadable, virtual]
                $table->string('type')->default('default');
                $table->unsignedBigInteger('post_id')->index();
                $table->timestamps();

                $table->foreign('post_id')
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
        Schema::dropIfExists('product_variants');
    }
};
