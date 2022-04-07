<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Juzaweb\Backend\Models\Taxonomy;

class AddLevelColumnToTaxonomiesTable extends Migration
{
    public function up()
    {
        Schema::table('taxonomies', function (Blueprint $table) {
            $table->integer('level')->default(0);
        });

//        $taxs = Taxonomy::get();
//        foreach ($taxs as $tax) {
//            $tax->touch();
//        }
    }

    public function down()
    {
        Schema::table('taxonomies', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
}
