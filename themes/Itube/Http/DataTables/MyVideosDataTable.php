<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itube\Http\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Juzaweb\Modules\VideoSharing\Models\Video;
use Yajra\DataTables\EloquentDataTable;

class MyVideosDataTable extends DataTable
{
    protected string $actionUrl = 'profile/my-videos/bulk';

    protected array $rawColumns = ['actions', 'checkbox', 'thumbnail', 'status'];

    public function query(Video $model): Builder
    {
        $userId = auth()->id();

        return $model->newQuery()
            ->with(['channel', 'media'])
            ->withTranslation()
            ->where('created_by', $userId)
            ->orderBy('created_at', 'desc');
    }

    public function getColumns(): array
    {
        return [
            Column::checkbox(),
            Column::id(),
            Column::computed('thumbnail')
                ->title(__('itube::translation.thumbnail'))
                ->width('100px')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('title')
                ->title(__('itube::translation.video_title')),
            Column::computed('status')
                ->title(__('itube::translation.status'))
                ->width('100px')
                ->addClass('text-center'),
            Column::make('views')
                ->title(__('itube::translation.views'))
                ->width('80px'),
            Column::createdAt(),
            Column::actions(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::delete(),
        ];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(url("profile/my-videos/{$model->id}/edit")),
            Action::delete(),
        ];
    }

    public function renderColumns(EloquentDataTable $builder): EloquentDataTable
    {
        $builder->editColumn('thumbnail', function (Video $video) {
            $thumbnail = $video->thumbnail;
            if ($thumbnail && filter_var($thumbnail, FILTER_VALIDATE_URL) &&
                (str_starts_with($thumbnail, 'http://') || str_starts_with($thumbnail, 'https://'))) {
                return '<img src="' . e($thumbnail) . '" alt="thumbnail" style="max-width: 80px; max-height: 60px; object-fit: cover;">';
            }
            return '<span class="text-muted">-</span>';
        });

        $builder->editColumn('status', function (Video $video) {
            $statusLabels = [
                'pending' => '<span class="badge badge-warning">' . __('itube::translation.pending') . '</span>',
                'published' => '<span class="badge badge-success">' . __('itube::translation.published') . '</span>',
                'rejected' => '<span class="badge badge-danger">' . __('itube::translation.rejected') . '</span>',
            ];
            return $statusLabels[$video->status->value] ?? '<span class="badge badge-secondary">' . e($video->status->value) . '</span>';
        });

        return $builder;
    }
}
