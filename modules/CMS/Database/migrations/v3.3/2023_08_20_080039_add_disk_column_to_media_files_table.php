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
        Schema::table(
            'media_files',
            function (Blueprint $table) {
                $table->string('disk', 50)->default('public')->index();
                $table->json('metadata')->nullable();
            }
        );

        Schema::table(
            'media_folders',
            function (Blueprint $table) {
                $table->string('disk', 50)->default('public')->index();
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
            'media_files',
            function (Blueprint $table) {
                $table->dropColumn(['disk', 'metadata']);
            }
        );

        Schema::table(
            'media_folders',
            function (Blueprint $table) {
                $table->dropColumn(['disk']);
            }
        );
    }
};
