<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Facades\HookAction;

class PostTypeDataTable extends DataTable
{
    protected $postType;

    protected $resourses;

    public function mount($postType)
    {
        if (is_string($postType)) {
            $postType = HookAction::getPostTypes($postType)->toArray();
        }

        $this->postType = $postType;
        $resourses = HookAction::getResource()
            ->where('post_type', $postType['key']);
        if ($resourses->isNotEmpty()) {
            $this->resourses = $resourses;
        }
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        $columns = [
            'title' => [
                'label' => trans('cms::app.title'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                },
            ],
            'status' => [
                'label' => trans('cms::app.status'),
                'width' => '10%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'cms::components.datatable.status',
                        compact(
                            'row'
                        )
                    )->render();
                },
            ],
        ];

        if ($this->resourses) {
            $columns['actions'] = [
                'label' => trans('cms::app.actions'),
                'width' => '15%',
                'align' => 'center',
                'sortable' => false,
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'cms::components.datatable.actions',
                        [
                            'row' => $row,
                            'resourses' => $this->resourses
                        ]
                    )->render();
                },
            ];
        }

        return $columns;
    }

    public function actions()
    {
        return array_merge(
            $this->makeModel()->getStatuses(),
            [
                'delete' => trans('cms::app.delete'),
            ]
        );
    }

    public function bulkActions($action, $ids)
    {
        $statuses = array_keys($this->makeModel()->getStatuses());
        $posts = $this->makeModel()->whereIn('id', $ids)->get();

        foreach ($posts as $post) {
            DB::beginTransaction();
            try {
                if ($action == 'delete') {
                    $post->delete();
                }

                if (in_array($action, $statuses)) {
                    $post->update(
                        [
                            'status' => $action,
                        ]
                    );
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }

    public function searchFields()
    {
        $data = [
            'keyword' => [
                'type' => 'text',
                'label' => trans('cms::app.keyword'),
                'placeholder' => trans('cms::app.keyword'),
            ],
            'status' => [
                'type' => 'select',
                'width' => '100px',
                'label' => trans('cms::app.status'),
                'options' => $this->makeModel()->getStatuses(),
            ],
        ];

        $taxonomies = HookAction::getTaxonomies($this->postType['key']);
        foreach ($taxonomies as $key => $taxonomy) {
            $data[$key] = [
                'type' => 'taxonomy',
                'label' => $taxonomy->get('label'),
                'taxonomy' => $taxonomy,
            ];
        }

        return $data;
    }

    public function rowAction($row)
    {
        $data = parent::rowAction($row);

        $data['view'] = [
            'label' => trans('cms::app.view'),
            'url' => $row->getLink(),
            'target' => '_blank',
        ];

        return $data;
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        /**
         * @var Builder $query
         */
        $query = $this->makeModel()->with(['taxonomies']);
        $query->where('type', '=', $this->postType['key']);
        $keyword = Arr::get($data, 'keyword');

        if (empty($data['status'])) {
            $query->where('status', '!=', 'trash');
        }

        $query->where(
            function (Builder $q) use ($keyword) {
                $q->where('title', JW_SQL_LIKE, "%{$keyword}%");
                $q->orWhere('description', JW_SQL_LIKE, "%{$keyword}%");
            }
        );

        return $query;
    }

    public function rowActionsFormatter($value, $row, $index)
    {
        return view(
            'cms::backend.items.datatable_item',
            [
                'value' => $row->{$row->getFieldName()},
                'row' => $row,
                'actions' => $this->rowAction($row),
                'editUrl' => $this->currentUrl .'/'. $row->id . '/edit',
            ]
        )
            ->render();
    }

    protected function makeModel()
    {
        return app($this->postType['model']);
    }
}
