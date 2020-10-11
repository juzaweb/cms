<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('package_id')->index()->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('package_id');
        });
    }
}
