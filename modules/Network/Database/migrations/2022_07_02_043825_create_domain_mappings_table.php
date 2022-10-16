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
            'network_domain_mappings',
            function (Blueprint $table) {
                $table->id();
                $table->string('domain', 100)->unique();
                $table->unsignedBigInteger('site_id');
                $table->timestamps();

                $table->foreign('site_id')
                    ->references('id')
                    ->on('network_sites')
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
        Schema::dropIfExists('network_domain_mappings');
    }
};
