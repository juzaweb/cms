<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'carts',
            function (Blueprint $table) {
                $table->id();
                $table->uuid('code')->unique();
                $table->json('items')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->decimal('discount', 20, 2)->default(0);
                $table->string('discount_codes', 150)->nullable();
                $table->string('discount_target_type', 50)->nullable();
                $table->timestamps();
    
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('carts');
    }
};
