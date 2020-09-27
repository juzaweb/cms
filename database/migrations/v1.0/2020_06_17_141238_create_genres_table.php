<?php

use App\Models\Category\Genres;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class CreateGenresTable extends Migration
{
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thumbnail', 150)->nullable();
            $table->string('name', 250);
            $table->text('description')->nullable();
            $table->string('slug', 200)->unique()->index();
            $table->tinyInteger('status')->default(1);
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('keywords', 320)->nullable();
            $table->timestamps();
        });
        
        $this->_createGenres();
    }
    
    public function down()
    {
        Schema::dropIfExists('genres');
    }
    
    private function _createGenres() {
        $genres = [
            'Action',
            'Adventure',
            'Comedy',
            'Sci-Fi & Fantasy',
            'Drama',
            'Animation',
            'Thriller',
            'Science Fiction',
            'Family',
            'Crime',
        ];
        
        foreach ($genres as $genre) {
            Genres::create([
                'name' => $genre,
                'slug' => Str::slug($genre),
            ]);
        }
    }
}
