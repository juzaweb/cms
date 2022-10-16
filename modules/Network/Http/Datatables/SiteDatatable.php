<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Network\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Network\Contracts\SiteManagerContract;
use Juzaweb\Network\Models\Site;

class SiteDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'domain' => [
                'label' => trans('cms::app.domain'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'status' => [
                'label' => trans('cms::app.status'),
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

    public function rowAction($row): array
    {
        $rows = parent::rowAction($row);
        $networkDomain = config('network.domain');
        $loginUrl = app(SiteManagerContract::class)->getLoginUrl($row);

        $rows['login'] = [
            'label' => 'Login',
            'url' => $loginUrl,
            'target' => '_blank',
        ];

        $rows['view'] = [
            'label' => trans('cms::app.view_site'),
            'url' => "http://{$row->domain}.{$networkDomain}",
            'target' => '_blank',
        ];

        return $rows;
    }

    public function query($data): Builder
    {
        $query = Site::query();
        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(
                function (Builder $q) use ($keyword) {
                    $q->where('domain', 'like', $keyword);
                }
            );
        }

        return $query;
    }

    public function actions(): array
    {
        return [
            'delete' => trans('cms::app.delete'),
            'banned' => trans('cms::app.banned'),
            'active' => trans('cms::app.active'),
        ];
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    Site::destroy([$id]);
                }

                break;
            case Site::STATUS_BANNED:
            case Site::STATUS_ACTIVE:
                Site::whereIn('id', $ids)
                    ->update(
                        [
                            'status' => $action
                        ]
                    );
                break;
        }
    }
}
