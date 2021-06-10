<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/9/2021
 * Time: 10:37 PM
 */

namespace Mymo\Core\Traits;

use Illuminate\Support\Arr;

/**
 * @method whereFilter(array $params)
 **/
trait ResourceModel
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $params
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeWhereFilter($builder, $params = [])
    {
        if (empty($this->searchAttributes)) {
            return $builder;
        }

        if (Arr::has($params, 'keyword')) {
            $builder->where(function ($q) use ($params) {
                $keyword = trim($params['keyword']);
                foreach ($this->searchAttributes as $attribute) {
                    $q->orWhere($attribute, 'like', '%'. $keyword .'%');
                }
            });
        }

        return $builder;
    }

    public function getFieldName()
    {
        if (!empty($this->fieldName)) {
            return $this->fieldName;
        }

        if (in_array('title', $this->fillable)) {
            return 'title';
        }

        return 'name';
    }
}