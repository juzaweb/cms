<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    larabizcom/larabiz
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\AdsManagement\Http\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\AdsManagement\Models\VideoAds;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Yajra\DataTables\EloquentDataTable;

class VideoAdsDatatable extends DataTable
{
    protected string $actionUrl = 'video-ads/bulk';

    public function query(VideoAds $model): Builder
    {
        return $model->newQuery();
    }

    public function getColumns(): array
    {
        return [
            Column::checkbox(),
            Column::id(),
			Column::editLink('name', admin_url('video-ads/{id}/edit'), __('ad-management::translation.name')),
			Column::computed('position'),
			Column::make('active'),
			Column::make('views'),
			Column::make('click'),
			Column::createdAt()
		];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::delete()->can('video-ads.delete'),
        ];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("video-ads/{$model->id}/edit"))
                ->can('video-ads.edit'),
            Action::delete()
                ->can('video-ads.delete'),
        ];
    }

    public function renderColumns(EloquentDataTable $builder): EloquentDataTable
    {
        return parent::renderColumns($builder)
            ->editColumn('active', function (VideoAds $model) {
                return $model->active ? __('ad-management::translation.yes') : __('ad-management::translation.no');
            });
    }
}
