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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Backend\Models\Comment;

class CommentDatatable extends DataTable
{
    protected $postType;

    public function mount($postType)
    {
        $this->postType = $postType;
    }

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'author' => [
                'label' => trans('cms::app.name'),
                'formatter' => function ($value, $row, $index) {
                    return e($row->getUserName());
                },
            ],
            'email' => [
                'label' => trans('cms::app.email'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    if ($value) {
                        return e($value);
                    }

                    return $row->user->email ?? '';
                },
            ],
            'content' => [
                'label' => trans('cms::app.content'),
                'formatter' => function ($value, $row, $index) {
                    return e($value);
                },
            ],
            'post' => [
                'label' => trans('cms::app.post'),
                'width' => '20%',
                'formatter' => function ($value, $row, $index) {
                    return $row->postType()->getTitle();
                },
            ],
            'status' => [
                'label' => trans('cms::app.status'),
                'width' => '10%',
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'cms::components.datatable.status',
                        compact('row')
                    )->render();
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

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data): Builder
    {
        $query = Comment::query()->with(['user']);
        $query->where('object_type', '=', $this->postType);

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(
                function (Builder $q) use ($keyword) {
                    $q->where('name', JW_SQL_LIKE, '%'. $keyword .'%');
                    $q->orWhere('content', JW_SQL_LIKE, '%'. $keyword .'%');
                }
            );
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function actions(): array
    {
        $actions = [];
        $statuses = Comment::allStatuses();
        foreach ($statuses as $key => $status) {
            $actions[$key] = [
                'label' => $status,
            ];
        }

        return array_merge($actions, parent::actions());
    }

    public function bulkActions($action, $ids)
    {
        $comments = Comment::whereIn('id', $ids)->get();
        foreach ($comments as $comment) {
            if ($action == 'delete') {
                $comment->delete();
            }

            if (in_array($action, array_keys(Comment::allStatuses()))) {
                $comment->update(
                    [
                        'status' => $action,
                    ]
                );
            }
        }
    }
}
