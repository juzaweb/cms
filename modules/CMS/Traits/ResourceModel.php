<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * @method Builder whereFilter(array $params)
 */
trait ResourceModel
{
    /**
     * @param  Builder  $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeWhereFilter($builder, $params = []): Builder
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

    public static function getStatuses(): array
    {
        return [
            'publish' => trans('cms::app.publish'),
            'draft' => trans('cms::app.draft'),
            'trash' => trans('cms::app.trash'),
        ];
    }
}
