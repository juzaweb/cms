<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('type', 50)->index()->default('posts');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('type', 50)->index()->default('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
