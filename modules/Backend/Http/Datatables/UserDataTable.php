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
use Juzaweb\CMS\Models\User;

class UserDataTable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'avatar' => [
                'label' => trans('cms::app.avatar'),
                'width' => '5%',
                'formatter' => function ($value, $row, $index) {
                    return '<img src="'. $row->getAvatar('150x150') .'" class="w-100"/>';
                },
            ],
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
            $query->where(
                function (Builder $q) use ($keyword) {
                    $q->where('name', JW_SQL_LIKE, '%'. $keyword .'%');
                    $q->orWhere('email', JW_SQL_LIKE, '%'. $keyword .'%');
                }
            );
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        /* Only update are not master admin  */
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
