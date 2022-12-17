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
    public function up(): void
    {
        Schema::table(
            'language_lines',
            function (Blueprint $table) {
                $table->string('object_type', 20)->nullable()->index();
                $table->string('object_key', 20)->nullable()->index();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(
            'language_lines',
            function (Blueprint $table) {
                $table->dropColumn(['object_type', 'object_key']);
            }
        );
    }
};
