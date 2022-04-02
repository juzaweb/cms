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
            'variants_attribute_values',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('variant_id');
                $table->unsignedBigInteger('attribute_id');
                $table->unsignedBigInteger('attribute_value_id');
                $table->foreign('variant_id')
                    ->references('id')
                    ->on('variants')
                    ->onDelete('cascade');
                $table->foreign('attribute_id')
                    ->references('id')
                    ->on('attributes')
                    ->onDelete('cascade');
                $table->foreign('attribute_value_id')
                    ->references('id')
                    ->on('attribute_values')
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
        Schema::dropIfExists('variants_attribute_values');
    }
};
