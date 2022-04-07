<?php

namespace Juzaweb\Movie\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Movie\Models\Video\VideoServer;

class VideoServerDatatable extends DataTable
{
    protected $type;

    protected $movieId;

    public function mount($type, $movieId)
    {
        $this->movieId = $movieId;

        $this->type = $type;
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
			'name' => [
                'label' => trans('mymo::app.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'order' => [
                'label' => trans('mymo::app.order'),
                'width' => '10%',
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
            'options' => [
                'label' => trans('mymo::app.actions'),
                'width' => '15%',
                'align' => 'center',
                'sortable' => false,
                'formatter' => function ($value, $row, $index) {
                    $upload = route('admin.movies.servers.upload.index', [
                        $this->type, $row->id
                    ]);

                    return '<a href="'. $upload .'" class="btn btn-success px-2 btn-sm"><i class="fa fa-upload"></i> '. trans('mymo::app.upload_videos') .'</a>';
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
        $query = VideoServer::query();

        $query->where('movie_id', '=', $this->movieId);

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', 'like', '%'. $keyword .'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
            VideoServer::destroy($ids);
            break;
        }
    }

    public function searchFields()
    {
        return [
            'keyword' => [
                'type' => 'text',
                'label' => trans('cms::app.keyword'),
                'placeholder' => trans('cms::app.keyword'),
            ],
            'status' => [
                'type' => 'select',
                'label' => trans('cms::app.status'),
                'options' => [
                    1 => trans('mymo::app.enabled'),
                    0 => trans('mymo::app.disabled'),
                ],
            ],
        ];
    }
}
