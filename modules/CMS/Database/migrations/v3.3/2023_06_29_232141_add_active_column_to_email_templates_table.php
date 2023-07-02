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
            'email_templates',
            function (Blueprint $table) {
                $table->boolean('active')->default(true)->index();
                $table->boolean('to_sender')->default(true);
                $table->json('to_emails')->nullable();
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
            'email_templates',
            function (Blueprint $table) {
                $table->dropColumn(['active', 'to_sender', 'to_emails']);
            }
        );
    }
};
