<?php

use Mymo\PostType\Models\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status', 50)->default('draft');
            $table->bigInteger('views')->default(0);
            $table->timestamps();
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('thumbnail', 250)->nullable();
            $table->string('slug', 150)->unique()->index();
            $table->longText('content')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('pages');
    }
    
    private function _createPages() {
        $pages = [
            'Terms of Use',
            'Privacy Policy',
        ];
        
        foreach ($pages as $page) {
            Page::create([
                'name' => $page,
                'slug' => \Illuminate\Support\Str::slug($page),
                'content' => $page . ' demo page',
            ]);
        }
    }
}
