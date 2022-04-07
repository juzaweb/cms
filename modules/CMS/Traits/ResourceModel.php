<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
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
            $builder->where(function (Builder $q) use ($keyword) {
                foreach ($this->searchFields as $key => $attribute) {
                    $q->orWhere($attribute, JW_SQL_LIKE, '%'. $keyword .'%');
                }
            });
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
