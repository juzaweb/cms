<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Models\Resource;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Repositories\BaseRepository;
use Juzaweb\CMS\Repositories\Criterias\FilterCriteria;
use Juzaweb\CMS\Repositories\Criterias\SearchCriteria;
use Juzaweb\CMS\Repositories\Criterias\SortCriteria;

class ResourceDatatable extends DataTable
{
    protected ?int $postId;
    protected string $type;
    protected ?int $parentId;
    protected Collection $setting;
    protected ?Collection $childs;

    public function mount($type, $postId, $parentId = null)
    {
        $this->type = $type;
        $this->postId = $postId;
        $this->parentId = $parentId;

        $childs = $this->getSetting()->where('parent', $type);
        if ($childs->isNotEmpty()) {
            $this->childs = $childs;
        }
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
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

        if (isset($this->childs)) {
            $columns['actions'] = [
                'label' => trans('cms::app.actions'),
                'width' => '15%',
                'align' => 'center',
                'sortable' => false,
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'cms::components.datatable.resource_actions',
                        [
                            'row' => $row,
                            'post_id' => $this->postId,
                            'resourses' => $this->childs
                        ]
                    )->render();
                },
            ];
        }

        return apply_filters(
            "resource_{$this->type}_datatable_columns",
            $columns
        );
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data): Builder
    {
        $query = $this->getQuery();

        if ($this->postId) {
            $query->where('post_id', '=', $this->postId);
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(
                function (Builder $q) use ($keyword) {
                    $q->where('name', JW_SQL_LIKE, '%'.$keyword.'%');
                    //$q->orWhere('description', JW_SQL_LIKE, '%'.$keyword.'%');
                }
            );
        }

        return $query;
    }

    public function getData(Request $request): array
    {
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = (int) $request->get('limit', 20);

        if ($repository = $this->getSetting($this->type)->get('repository')) {
            /**
             * @var BaseRepository $repository
             */
            $repository = app($repository);
            $queries = $request->query();
            if ($this->postId) {
                $queries['post_id'] = $this->postId;
            }
            $queries['sort_by'] = $queries['sort'];
            $queries['sort_order'] = $queries['order'];
            $repository->pushCriteria(new SearchCriteria($queries));
            $repository->pushCriteria(new FilterCriteria($queries));
            $repository->pushCriteria(new SortCriteria($queries));
            $page = $offset <= 0 ? 1 : (round($offset / $limit)) + 1;
            $results = $repository->adminPaginate($limit, $page);
            $count = $results->total();
            $rows = $results->items();
        } else {
            $query = $this->query($request->all());
            $count = $query->count();
            $query->orderBy($sort, $order);
            $query->offset($offset);
            $query->limit($limit);
            $rows = $query->get();
        }

        return [$count, $rows];
    }

    public function bulkActions($action, $ids)
    {
        $rows = $this->getQuery()->whereIn('id', $ids)->get();
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

    protected function getSetting(?string $type = null): ?Collection
    {
        if (empty($type)) {
            return HookAction::getResource();
        }

        if (isset($this->setting)) {
            return $this->setting;
        }

        $this->setting = HookAction::getResource($type);

        return $this->setting;
    }

    protected function getQuery(): Builder
    {
        if ($repository = $this->getSetting($this->type)->get('repository')) {
            $query = app($repository)->query();
        } else {
            $query = Resource::query();
            $query->where('type', '=', $this->type);
        }

        return $query;
    }
}
