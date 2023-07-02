<?php

namespace Juzaweb\CMS\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Juzaweb\CMS\Models\User;

trait UseChangeBy
{
    public static function bootUseChangeBy(): void
    {
        static::saving(
            function ($model) {
                if (Auth::check()) {
                    if (Schema::hasColumns($model->getTable(), ['created_by'])) {
                        if (empty($model->id) && !$model->getAttribute('created_by')) {
                            $model->created_by = Auth::id();
                        }
                    }

                    if (Schema::hasColumns($model->getTable(), ['updated_by'])) {
                        if (!$model->getAttribute('updated_by')) {
                            $model->updated_by = Auth::id();
                        }
                    }
                }
            }
        );
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
