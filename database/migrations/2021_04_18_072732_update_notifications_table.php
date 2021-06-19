<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->string("notifiable_type", 150);
                $table->unsignedBigInteger("notifiable_id");
                $table->index(["notifiable_type", "notifiable_id"], 'notifiable_index');
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
