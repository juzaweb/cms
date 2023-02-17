<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table(
            'email_templates',
            function (Blueprint $table) {
                $table->string('email_hook', 100)->nullable();
            }
        );

        Schema::table(
            'posts',
            function (Blueprint $table) {
                $table->bigInteger('created_by')->nullable()->index();
                $table->bigInteger('updated_by')->nullable()->index();
            }
        );

        DB::table('email_templates')
            ->where('code', '=', 'verification')
            ->update(
                [
                'email_hook' => 'register_success'
                ]
            );
    }

    public function down()
    {
        Schema::table(
            'email_templates',
            function (Blueprint $table) {
                $table->dropColumn('email_hook');
            }
        );

        Schema::table(
            'posts',
            function (Blueprint $table) {
                $table->dropColumn(['created_by', 'updated_by']);
            }
        );
    }
};
