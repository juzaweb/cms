<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermTaxonomiesTable extends Migration
{
    public function up()
    {
        Schema::create('term_taxonomies', function (Blueprint $table) {
            $table->bigInteger('term_id')->index();
            $table->bigInteger('taxonomy_id')->index();
            $table->string('term_type', 100)->index();
            $table->primary([
                'term_id',
                'term_type',
                'taxonomy_id'
            ]);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('term_taxonomies');
    }
}
