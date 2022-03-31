<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'roles',
            function (Blueprint $table) {
                $table->string('description', 200)->nullable();
            }
        );

        Schema::table(
            'permissions',
            function (Blueprint $table) {
                $table->unsignedBigInteger('group_id')->index();
                $table->string('description', 200)->nullable();
                $table->foreign('group_id')
                    ->references('id')
                    ->on('permission_groups');
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
        Schema::table(
            'roles',
            function (Blueprint $table) {
                $table->dropColumn(['description']);
            }
        );

        Schema::table(
            'permissions',
            function (Blueprint $table) {
                $prefix = DB::getTablePrefix();
                $table->dropForeign("{$prefix}permissions_group_id_foreign");
                $table->dropColumn(['group_id', 'description']);
            }
        );
    }
}
