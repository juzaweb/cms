<?php

namespace Juzaweb\Movie\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Movie\Models\Subtitle;

class SubtitleDatatable extends DataTable
{
    public $page_type, $file_id;

    public function mount($page_type, $file_id)
    {
        $this->page_type = $page_type;
        $this->file_id = $file_id;
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'label' => [
                'label' => trans('mymo::app.label'),
                'formatter' => [$this, 'rowActionsFormatter']
            ],
            'order' => [
                'label' => trans('mymo::app.order'),
                'width' => '10%',
                'align' => 'center',
            ],
            'url' => [
                'label' => trans('mymo::app.url'),
                'width' => '20%',
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
        $query = Subtitle::query();
        $query->where('file_id', '=', $this->file_id);
        $status = $data['status'] ?? null;

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('label', 'like', '%'. $keyword .'%');
                $q->orWhere('url', 'like', '%'. $keyword .'%');
            });
        }

        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                Subtitle::destroy($ids);
                break;
        }
    }
}
