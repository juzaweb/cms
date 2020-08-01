<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 30)->unique();
            $table->string('subject', 300);
            $table->text('content')->nullable();
            $table->text('params')->nullable();
            $table->timestamps();
        });
        
        DB::table('email_templates')->insert([
            [
                'code' => 'user_verification',
                'subject' => 'Verify your account',
                'content' => '<p>Hello {name},</p>
<p>Thank you for register. Please click the link below to Verify your account</p>
<p><a href="{url}" target="_blank">Verify account</a></p>',
            ],
            [
                'code' => 'forgot_password',
                'subject' => 'Password Reset for you account',
                'content' => '<p>Someone has requested a password reset for the following account:</p>
<p>Email: {email}</p>
<p>If this was a mistake, just ignore this email and nothing will happen.To reset your password, visit the following address:</p>
<p><a href="{url}" target="_blank">{url}</a></p>',
            ]
        ]);
    }
    
    public function down()
    {
        Schema::dropIfExists('email_templates');
    }
}
