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
            $table->text('params')->nullable();
            $table->string('template_file', 300);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('email_templates');
    }
}
