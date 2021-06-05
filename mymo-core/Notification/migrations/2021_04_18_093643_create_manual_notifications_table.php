<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateManualNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('manual_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method', 150)->index()->nullable();
            $table->text('users');
            $table->text('data');
            $table->tinyInteger('status')->default(2);
            $table->text('error')->nullable();
            $table->timestamps();
        });

        if (!DB::table('email_templates')->where('code', '=', 'notification')->exists()) {
            DB::table('email_templates')->insert([
                'code' => 'notification',
                'subject' => '{subject}',
                'body' => '{body}',
                'params' => json_encode([
                    'subject' => 'Subject notify',
                    'body' => 'Body notify',
                    'name' => 'User name',
                    'email' => 'User Email address',
                    'url' => 'Url notify',
                    'image' => 'Image notify',
                ]),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('manual_notifications');
    }
}
