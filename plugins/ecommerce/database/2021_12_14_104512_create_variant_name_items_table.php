<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantNameItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'variant_name_items',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('variant_name_id')->index();

                $table->foreign('variant_name_id')
                    ->references('id')
                    ->on('variant_names')
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
        Schema::dropIfExists('variant_name_items');
    }
}
