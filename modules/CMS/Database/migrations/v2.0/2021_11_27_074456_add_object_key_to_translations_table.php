<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObjectKeyToTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'jw_translations',
            function (Blueprint $table) {
                $table->string('object_type', 50)->nullable()->index();
                $table->string('object_key', 50)->nullable()->index();
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
        Schema::table(
            'jw_translations',
            function (Blueprint $table) {
                $table->dropColumn(['object_type', 'object_key']);
            }
        );
    }
}
