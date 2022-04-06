<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Juzaweb\CMS\Facades\HookAction;

class CreateSearchTable extends Migration
{
    public function up()
    {
        Schema::create('search', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 190)->index();
            $table->string('description', 250)->nullable();
            $table->string('keyword', 190)->nullable();
            $table->string('slug', 150)->index();
            $table->unsignedBigInteger('post_id')->index();
            $table->string('post_type', 50)->index();
            $table->string('status', 50)->index();
            $table->unique(['post_id', 'post_type']);
            $table->timestamps();
        });

        /*if (DB::getDefaultConnection() == 'mysql') {
            $prefix = DB::getTablePrefix();
            DB::statement('ALTER TABLE `'. $prefix .'search` ADD FULLTEXT index_search_title(title);');
            DB::statement('ALTER TABLE `'. $prefix .'search` ADD FULLTEXT index_search_description(description);');
            DB::statement('ALTER TABLE `'. $prefix .'search` ADD FULLTEXT index_search_keyword(keyword);');
        }*/

//        $types = HookAction::getPostTypes();
//        foreach ($types as $type) {
//            $posts = app($type->get('model'))->get();
//            foreach ($posts as $post) {
//                $post->touch();
//            }
//        }
    }

    public function down()
    {
        Schema::dropIfExists('search');
    }
}
