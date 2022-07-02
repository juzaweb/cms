<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CmsMultisite\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CmsMultisite\Models\Database;

class DatabaseDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'dbhost' => [
                'label' => 'dbhost',
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'dbname' => [
                'label' => 'dbname',
                'width' => '15%',
            ],
            'dbuser' => [
                'label' => 'dbuser',
                'width' => '15%',
            ],
            'dbprefix' => [
                'label' => 'dbprefix',
                'width' => '15%',
            ],
            'count' => [
                'label' => 'Sites',
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

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $query = Database::query();
        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('dbhost', 'like', $keyword);
                $q->orWhere('dbname', 'like', $keyword);
                $q->orWhere('dbprefix', 'like', $keyword);
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    /*
                    Site::destroy([$id]);*/
                }

                break;
        }
    }
}
