<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Juzaweb\Network\Models\Site;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'network_databases',
            function (Blueprint $table) {
                $table->id();
                $table->string('dbconnection', 100)->default('mysql');
                $table->string('dbhost', 100);
                $table->string('dbname', 100);
                $table->string('dbuser', 100);
                $table->string('dbpass', 100)->nullable();
                $table->integer('dbport')->nullable();
                $table->string('dbprefix', 50)->nullable();
                $table->integer('count')->default(0);
                $table->tinyInteger('active')->default(1);
                $table->timestamps();
            }
        );

        Schema::create(
            'network_sites',
            function (Blueprint $table) {
                $table->id();
                $table->string('domain', 150)->unique();
                $table->string('status', 15)->default(Site::STATUS_VERIFICATION);
                $table->unsignedBigInteger('db_id')->nullable();
                $table->timestamps();

                $table->foreign('db_id')
                    ->references('id')
                    ->on('network_databases')
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
        Schema::dropIfExists('network_sites');
        Schema::dropIfExists('network_databases');
    }
};
