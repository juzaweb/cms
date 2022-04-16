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
            'variants_attributes',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_variant_id');
                $table->unsignedBigInteger('attribute_id');
                $table->foreign('product_variant_id', 'product_variant_id_foreign')
                    ->references('id')
                    ->on('product_variants')
                    ->onDelete('cascade');
                $table->foreign('attribute_id', 'attribute_id_foreign')
                    ->references('id')
                    ->on('attributes')
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
        Schema::dropIfExists('variants_attributes');
    }
};
