<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Support\Arr;
use Juzaweb\CMS\Traits\ResourceModel;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use ResourceModel;

    protected $table = 'roles';

    public function attributeLabel($key)
    {
        $label = Arr::get($this->attributeLabels(), $key);
        if (empty($label)) {
            $label = trans("cms::app.{$key}");
        }

        return $label;
    }

    public function attributeLabels()
    {
        return [];
    }
}
