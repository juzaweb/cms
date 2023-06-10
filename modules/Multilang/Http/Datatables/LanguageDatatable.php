<?php

namespace Juzaweb\Multilang\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Models\Language;

class LanguageDatatable extends DataTable
{
    protected string $sortName = 'default';

    public function columns()
    {
        return [
            'name' => [
                'label' => trans('cms::app.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'default' => [
                'label' => trans('cms::app.default'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    return '<input
                    type="radio"
                    class="form-control"
                    name="default" '. ($value == 1 ? 'checked': '') .'
                    value="'. $row->code .'">';
                },
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

    public function rowAction($row)
    {
        return [
            'delete' => [
                'label' => trans('cms::app.delete'),
                'class' => 'text-danger',
                'action' => 'delete',
            ],
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
        $query = Language::query();
        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', 'like', $keyword);
                $q->orWhere('code', 'like', $keyword);
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        $count = Language::count(['id']);
        if ($count <= 1) {
            return;
        }

        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    $isDefault = Language::where('id', '=', $id)
                        ->where('default', '=', true)
                        ->exists();

                    if ($isDefault) {
                        continue;
                    }

                    Language::destroy([$id]);
                }

                break;
        }
    }
}
