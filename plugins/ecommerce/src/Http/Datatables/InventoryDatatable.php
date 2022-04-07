<?php

namespace Juzaweb\Ecommerce\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Backend\Models\Post;

class InventoryDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'title' => [
                'label' => trans('cms::app.name'),
            ],
            'quantity' => [
                'label' => trans('ecom::content.quantity'),
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ]
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $query = Post::query();
        $query->select(
            [
                'id',
                'title',
                'json_metas'
            ]
        );

        $query->where('type', '=', 'products');

        $query->whereMeta('inventory_management', 1);

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('title', JW_SQL_LIKE, '%'. $keyword .'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                Inventory::destroy($ids);
                break;
        }
    }
}
