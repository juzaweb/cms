<?php

namespace Juzaweb\CMS\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Juzaweb\CMS\Models\User;

trait UseChangeBy
{
    public static function bootUseChangeBy()
    {
        static::saving(function ($model) {
            if (Auth::check()) {
                if (Schema::hasColumns($model->getTable(), ['created_by', 'updated_by'])) {
                    if (empty($model->id)) {
                        $model->created_by = Auth::id();
                    }

                    $model->updated_by = Auth::id();
                }
            }
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
