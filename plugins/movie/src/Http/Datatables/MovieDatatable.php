<?php

namespace Juzaweb\Movie\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Backend\Http\Datatables\PostTypeDataTable;
use Juzaweb\Backend\Models\Post;

class MovieDatatable extends PostTypeDataTable
{
    protected $tvSeries;

    public function mount($postType, $tvSeries = 0)
    {
        parent::mount($postType);

        $this->tvSeries = $tvSeries;
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'thumbnail' => [
                'label' => trans('mymo::app.thumbnail'),
                'width' => '10%',
                'formatter' => function ($value, $row, $index) {
                    return '<img src="'. $row->getThumbnail() .'" class="w-100" />';
                }
            ],
            'title' => [
                'label' => trans('mymo::app.name'),
                'formatter' => [$this, 'rowActionsFormatter']
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
            'actions' => [
                'label' => trans('mymo::app.actions'),
                'width' => '15%',
                'sortable' => false,
                'formatter' => function ($value, $row, $index) {
                    $preview = $row->getLink();
                    $upload = route('admin.movies.servers.index', [
                        $this->tvSeries == 0 ? 'movies' : 'tv-series',
                        $row->id
                    ]);
                    $download = route('admin.movies.download', [
                        $this->tvSeries == 0 ? 'movies' : 'tv-series',
                        $row->id
                    ]);

                    return '<div class="dropdown d-inline-block mb-2 mr-2">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          Options
        </button>
        <div class="dropdown-menu" role="menu" style="">
          <a href="'.$upload.'" class="dropdown-item">Upload videos</a>
          <a href="'.$download.'" class="dropdown-item">Download videos</a>
          <a href="'.$preview.'" target="_blank" class="dropdown-item">Preview</a>
        </div>
    </div>';
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
        $query->whereMeta('tv_series', $this->tvSeries);

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', 'like', '%'. $keyword .'%');
                $q->orWhere('description', 'like', '%'. $keyword .'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                Movie::destroy($ids);
                break;
        }
    }
}
