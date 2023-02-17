<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    protected array $tables = ['posts', 'taxonomies', 'email_templates', 'resources', 'menus'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tb) {
            Schema::table(
                $tb,
                function (Blueprint $table) use ($tb) {
                    $table->uuid()->nullable()->unique("{$tb}_uuid_unique");
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $tb) {
            Schema::table(
                $tb,
                function (Blueprint $table) use ($tb) {
                    $table->dropUnique("{$tb}_uuid_unique");
                    $table->dropColumn('uuid');
                }
            );
        }
    }
};
