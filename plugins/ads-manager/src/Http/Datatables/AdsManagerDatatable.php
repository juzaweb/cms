<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\AdsManager\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\AdsManager\Models\Ads;

class AdsManagerDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'name' => [
                'label' => trans('cms::app.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'position' => [
                'label' => trans('cms::app.position'),
                'width' => '15%',
            ],
            'active' => [
                'label' => trans('cms::app.active'),
                'width' => '15%',
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                },
            ],
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data): Builder
    {
        $query = Ads::query();

        if ($search = Arr::get($data, 'keyword')) {
            $query->where(
                function (Builder $q) use ($search) {
                    $q->where('position', 'like', '%'. $search .'%');
                    $q->orWhere('name', 'like', '%'. $search .'%');
                }
            );
        }

        $active = Arr::get($data, 'active');

        if (!is_null($active)) {
            $query->where('active', '=', $active);
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        $rows = Ads::whereIn('id', $ids)->get();
        switch ($action) {
            case 'delete':
                foreach ($rows as $row) {
                    $row->delete();
                }
                break;
        }
    }
}
