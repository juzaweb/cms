<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'email_templates',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 50)->unique();
                $table->string('subject', 250);
                $table->text('body');
                $table->text('params')->nullable();
                $table->string('layout', 150)->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
