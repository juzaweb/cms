<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_positions', function (Blueprint $table) {
            $table->id();
            $table->string('position', 64);
            $table->string('theme', 20);
            $table->uuidMorphs('positionable');

            $table->unique(['position', 'theme', 'positionable_type', 'positionable_id'], 'ads_positions_unique');
            $table->index(['position', 'theme'], 'ads_positions_position_theme_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_positions');
    }
};
