<?php

namespace Juzaweb\Movie\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Movie\Models\Video\VideoFile;

class VideoFileDatatable extends DataTable
{
    public $type, $server_id;

    public function mount($type, $server_id)
    {
        $this->type = $type;
        $this->server_id = $server_id;
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
            'url' => [
                'label' => trans('mymo::app.url'),
                'width' => '15%',
            ],
            'source' => [
                'label' => trans('mymo::app.source'),
                'width' => '15%',
            ],
            'order' => [
                'label' => trans('mymo::app.order'),
                'width' => '10%',
            ],
            'status' => [
                'label' => trans('mymo::app.status'),
                'width' => '10%',
                'formatter' => function ($value, $row, $index) {
                    if ($value == 1) {
                        return '<span class="text-success">'. trans('mymo::app.enabled') .'</span>';
                    }
                    return '<span class="text-danger">'. trans('mymo::app.disabled') .'</span>';
                }
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '10%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
            'actions' => [
                'label' => trans('mymo::app.actions'),
                'width' => '10%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return '<a href="'. route('admin.movies.servers.upload.subtitle.index', [$this->type, $row->id]) .'" class="btn btn-success btn-sm px-2"><i class="fa fa-plus"></i> '. trans('mymo::app.add_subtitle') .'</a>';
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
        $query = VideoFile::query();

        $query->where('server_id', '=', $this->server_id);

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('label', 'like', '%'. $keyword .'%');
                $q->orWhere('url', 'like', '%'. $keyword .'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                VideoFile::destroy($ids);
                break;
        }
    }
}
