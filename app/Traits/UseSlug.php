<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UseSlug {
    
    public function createSlug() {
        if ($this->name) {
            $this->slug = Str::slug($this->name);
            $this->slug = substr($this->slug, 0, 150);
            
            $count = self::where('id', '!=', $this->id)
                ->where('slug', '=', $this->slug)
                ->count();
            
            if ($count > 0) {
                $this->slug .= '-'. ($count + 1);
            }
        }
    }
    
}