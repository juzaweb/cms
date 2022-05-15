<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * @method \Illuminate\Database\Eloquent\Builder whereFilter(array $params)
 */
trait ResourceModel
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $params
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFilter($builder, $params = [])
    {
        if (empty($this->searchFields)) {
            $this->searchFields = [$this->getFieldName()];
        }

        if ($keyword = Arr::get($params, 'keyword')) {
            $builder->where(
                function (Builder $q) use ($keyword) {
                    foreach ($this->searchFields as $key => $attribute) {
                        $q->orWhere($attribute, JW_SQL_LIKE, '%'. $keyword .'%');
                    }
                }
            );
        }

        return $builder;
    }

    public function getFieldName()
    {
        if (! empty($this->fieldName)) {
            return $this->fieldName;
        }

        if (in_array('title', $this->fillable)) {
            return 'title';
        }

        return 'name';
    }
}
