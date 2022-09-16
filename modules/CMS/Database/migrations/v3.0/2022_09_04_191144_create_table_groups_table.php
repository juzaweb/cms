<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'table_groups',
            function (Blueprint $table) {
                $table->id();
                $table->string('table', 50)->unique();
                $table->bigInteger('total_rows')->default(0)->index();
                $table->json('migrations');
            }
        );

        Schema::create(
            'table_group_tables',
            function (Blueprint $table) {
                $table->id();
                $table->string('table', 50)->index();
                $table->string('real_table', 50)->unique();
                $table->unsignedBigInteger('table_group_id');
                $table->bigInteger('total_rows')->default(0)->index();
                $table->foreign('table_group_id')
                    ->references('id')
                    ->on('table_groups')
                    ->onDelete('cascade');
            }
        );

        Schema::create(
            'table_group_datas',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('table_group_id');
                $table->unsignedBigInteger('table_group_table_id');

                $table->string('table', 50)->index();
                $table->string('real_table', 50)->index();
                $table->string('table_key', 32)->index();

                $table->unique(['real_table', 'table_key']);

                $table->foreign('table_group_id')
                    ->references('id')
                    ->on('table_groups')
                    ->onDelete('cascade');

                $table->foreign('table_group_table_id')
                    ->references('id')
                    ->on('table_group_tables')
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
        Schema::dropIfExists('table_group_datas');
        Schema::dropIfExists('table_group_tables');
        Schema::dropIfExists('table_groups');
    }
};
