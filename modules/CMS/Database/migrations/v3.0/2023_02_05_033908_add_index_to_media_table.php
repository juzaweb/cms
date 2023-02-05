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
            'media_files',
            function (Blueprint $table) {
                $table->index(['type']);
                $table->index(['mime_type']);
                $table->index(['path']);
                $table->index(['extension']);
                $table->index(['size']);
            }
        );
    
        Schema::table(
            'media_folders',
            function (Blueprint $table) {
                $table->index(['type']);
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
            'media_files',
            function (Blueprint $table) {
                $table->dropIndex(['type']);
                $table->dropIndex(['mime_type']);
                $table->dropIndex(['path']);
                $table->dropIndex(['extension']);
                $table->dropIndex(['size']);
            }
        );
    
        Schema::table(
            'media_folders',
            function (Blueprint $table) {
                $table->dropIndex(['type']);
            }
        );
    }
};
