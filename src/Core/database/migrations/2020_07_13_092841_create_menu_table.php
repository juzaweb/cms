<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->text('content')->nullable();
            $table->timestamps();
        });
        
        //$this->_createMainMenu();
        //$this->_createFooterMenu();
    }
    
    public function down()
    {
        Schema::dropIfExists('menu');
    }
    
    private function _createMainMenu() {
        $items = [
            [
                'content' => 'Home',
                'url' => '/',
                'new_tab' => 0,
            ],
            [
                'content' => 'Latest Movies',
                'url' => '/latest-movies',
                'new_tab' => 0,
            ],
            [
                'content' => 'Movies',
                'url' => '/movies',
                'new_tab' => 0,
            ],
            [
                'content' => 'Tv series',
                'url' => '/tv-series',
                'new_tab' => 0,
            ],
            [
                'content' => 'Genre',
                'url' => '#',
                'new_tab' => 0,
                'children' => $this->_getGenresMenu(),
            ],
            [
                'content' => 'Country',
                'url' => '#',
                'new_tab' => 0,
                'children' => $this->_getCountriesMenu(),
            ]
        ];
    
        DB::table('menu')->insert([
            'name' => 'Main',
            'content' => json_encode($items),
        ]);
    }
    
    private function _createFooterMenu() {
        $items = [
            [
                'content' => 'Home',
                'url' => '/',
                'new_tab' => 0,
            ],
            [
                'content' => 'Latest Movies',
                'url' => '/latest-movies',
                'new_tab' => 0,
            ],
            [
                'content' => 'Movies',
                'url' => '/movies',
                'new_tab' => 0,
            ],
            [
                'content' => 'Tv series',
                'url' => '/tv-series',
                'new_tab' => 0,
            ],
            [
                'content' => 'Privacy Policy',
                'url' => '/page/privacy-policy',
                'new_tab' => 0,
            ],
            [
                'content' => 'Terms of Use',
                'url' => '/page/terms-of-use',
                'new_tab' => 0,
            ]
        ];
    
        DB::table('menu')->insert([
            'name' => 'Footer',
            'content' => json_encode($items),
        ]);
    }
    
    private function _getGenresMenu() {
        $genres = Genres::where('status', '=', 1)
            ->get(['name', 'slug']);
        $result = [];
        
        foreach ($genres as $genre) {
            $result[] = [
                'content' => $genre->name,
                'url' => '/genre/' . $genre->slug,
                'new_tab' => 0,
            ];
        }
        
        return $result;
    }
    
    private function _getCountriesMenu() {
        $genres = Countries::where('status', '=', 1)
            ->get(['name', 'slug']);
        $result = [];
        
        foreach ($genres as $genre) {
            $result[] = [
                'content' => $genre->name,
                'url' => '/country/' . $genre->slug,
                'new_tab' => 0,
            ];
        }
        
        return $result;
    }
}
