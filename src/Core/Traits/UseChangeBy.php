<?php

namespace Mymo\Core\Traits;

//use Illuminate\Support\Facades\Auth;

trait UseChangeBy {
    public static function bootUseChangeBy()
    {
        static::saving(function ($model) {
            /*if (\Auth::check()) {
                if (empty($model->id)) {
                    $model->created_by = Auth::id();
                }
    
                $model->updated_by = Auth::id();
            }*/
        });
    }
}
