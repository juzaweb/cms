<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Juzaweb\Abstracts\DataTable;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Backend\Models\Resource;

class ResourceDatatable extends DataTable
{
    protected $postId;

    protected $type;

    protected $childs;

    public function mount($type, $postId)
    {
        $this->type = $type;
        $this->postId = $postId;

        $childs = HookAction::getResource()
            ->where('parent', $type);
        if ($childs->isNotEmpty()) {
            $this->childs = $childs;
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
            'name' => [
                'label' => trans('cms::app.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'display_order' => [
                'label' => trans('cms::app.display_order'),
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
        ];

        if ($this->childs) {
            $columns['actions'] = [
                'label' => trans('cms::app.actions'),
                'width' => '15%',
                'align' => 'center',
                'sortable' => false,
                'formatter' => function ($value, $row, $index) {
                    return view('cms::components.datatable.resource_actions', [
                        'row' => $row,
                        'post_id' => $this->postId,
                        'resourses' => $this->childs
                    ])->render();
                },
            ];
        }

        $columns = apply_filters(
            "resource_{$this->type}_datatable_columns",
            $columns
        );

        return $columns;
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $query = Resource::query();
        $query->where('type', '=', $this->type);

        if ($this->postId) {
            $query->where('post_id', '=', $this->postId);
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', 'ilike', '%'.$keyword.'%');
                $q->orWhere('description', 'ilike', '%'.$keyword.'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        $rows = Resource::whereIn('id', $ids)->get();
        foreach ($rows as $row) {
            DB::beginTransaction();
            try {
                if ($action == 'delete') {
                    $row->delete();
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
