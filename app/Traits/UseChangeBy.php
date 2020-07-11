<?php

namespace App\Traits;

trait UseChangeBy {
    
    public static function bootUseChangeBy()
    {
        static::saving(function ($model) {
            if (empty($model->id)) {
                $model->created_by = \Auth::id();
            }
            
            $model->updated_by = \Auth::id();
        });
    }
    
}