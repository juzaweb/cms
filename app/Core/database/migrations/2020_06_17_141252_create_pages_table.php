<?php

use App\Core\Models\Pages;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('thumbnail', 250)->nullable();
            $table->string('slug', 150)->unique()->index();
            $table->longText('content')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('keywords', 320)->nullable();
            $table->timestamps();
        });
        
        $this->_createPages();
    }
    
    public function down()
    {
        Schema::dropIfExists('pages');
    }
    
    private function _createPages() {
        $pages = [
            'Terms of Use',
            'Privacy Policy',
        ];
        
        foreach ($pages as $page) {
            Pages::create([
                'name' => $page,
                'slug' => \Illuminate\Support\Str::slug($page),
                'content' => $page . ' demo page',
            ]);
        }
    }
}
