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

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Abstracts\DataTable;
use Juzaweb\Models\User;

class UserDataTable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'name' => [
                'label' => trans('cms::app.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'email' => [
                'label' => trans('cms::app.email'),
                'width' => '15%',
                'align' => 'center',
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
        $data = parent::rowAction($row);

        $data['edit'] = [
            'label' => trans('cms::app.edit'),
            'url' => route('admin.users.edit', [$row->id]),
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
        $query = User::query();

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', 'ilike', '%'. $keyword .'%');
                $q->orWhere('email', 'ilike', '%'. $keyword .'%');
            });
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        $ids = User::whereIn('id', $ids)
            ->whereIsAdmin(0)
            ->pluck('id')
            ->toArray();

        switch ($action) {
            case 'delete':
                User::destroy($ids);
                break;
        }
    }
}
