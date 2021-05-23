<?php

use App\Core\Models\Category\Countries;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('slug', 150)->unique();
            $table->string('description', 300)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('keywords', 320)->nullable();
            $table->timestamps();
        });
        
        $this->_createCountries();
    }
    
    public function down()
    {
        Schema::dropIfExists('countries');
    }
    
    private function _createCountries() {
        $countries = [
            'United States',
            'Denmark',
            'China',
            'Japan',
            'Korean',
            'Thailand',
            'India',
            'France',
            'Italy',
            'Canada',
        ];
        
        foreach ($countries as $country) {
            Countries::create([
                'name' => $country,
                'slug' => Str::slug($country),
            ]);
        }
    }
}
