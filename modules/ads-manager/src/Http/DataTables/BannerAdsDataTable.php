<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Modules\AdsManagement\Http\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\AdsManagement\Models\BannerAds;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Yajra\DataTables\EloquentDataTable;

class BannerAdsDataTable extends DataTable
{
    protected string $actionUrl = 'banner-ads/bulk';

    public function query(BannerAds $model): Builder
    {
        return $model->newQuery();
    }

    public function getColumns(): array
    {
        return [
            Column::checkbox(),
            Column::id(),
            Column::editLink('name', admin_url('banner-ads/{id}/edit'), __('ad-management::translation.name')),
            Column::make('active', __('ad-management::translation.status'))->width('100px'),
            Column::createdAt(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::make(__('ad-management::translation.activate'))
                ->icon('fas fa-check-circle')
                ->color('success')
                ->can('banner-ads.edit'),
            BulkAction::make(__('ad-management::translation.deactivate'))
                ->icon('fas fa-times-circle')
                ->color('warning')
                ->can('banner-ads.edit'),
            BulkAction::delete()->can('banner-ads.delete'),
        ];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("banner-ads/{$model->id}/edit"))
                ->can('banner-ads.edit'),
            Action::delete()
                ->can('banner-ads.delete'),
        ];
    }

    public function renderColumns(EloquentDataTable $builder): EloquentDataTable
    {
        return parent::renderColumns($builder)
            ->editColumn('active', function (BannerAds $model) {
                return $model->active ? '<span class="badge badge-success">' . __('ad-management::translation.active') . '</span>'
                    : '<span class="badge badge-secondary">' . __('ad-management::translation.inactive') . '</span>';
            })
            ->rawColumns(['active']);
    }
}
