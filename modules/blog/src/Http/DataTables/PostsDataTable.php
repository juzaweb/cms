<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\Blog\Http\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PostsDataTable extends DataTable
{
    protected string $actionUrl = 'posts/bulk';

    protected array $rawColumns = ['actions', 'checkbox', 'thumbnail', 'status'];

    public function query(Post $model): QueryBuilder
    {
        return $model->newQuery()
            ->withTranslation()
            ->with(['media'])
            ->filter(request()->all());
    }

    public function getColumns(): array
    {
        return [
            Column::checkbox(),
            Column::id(),
            Column::actions(),
            Column::computed('thumbnail')
                ->title(__('blog::translation.thumbnail'))
                ->width('100px')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::editLink('title', admin_url('posts/{id}/edit'), __('blog::translation.title')),
            Column::computed('status')
                ->title(__('blog::translation.status'))
                ->width('100px')
                ->addClass('text-center')
                ->orderable(false),
            Column::createdAt(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::delete()->can('posts.delete'),
            BulkAction::make(__('blog::translation.translate'), null, 'fas fa-language')
                ->type('url')
                ->action('translate')
                ->can('posts.edit'),
        ];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("posts/{$model->id}/edit"))
                ->can('posts.edit'),
            Action::delete()
                ->can('posts.delete'),
        ];
    }

    public function renderColumns(EloquentDataTable $builder): EloquentDataTable
    {
        $builder->editColumn('thumbnail', function (Post $post) {
            $thumbnail = $post->thumbnail;
            if ($thumbnail && filter_var($thumbnail, FILTER_VALIDATE_URL)) {
                return '<img src="' . e($thumbnail) . '" alt="thumbnail" style="max-width: 80px; max-height: 60px; object-fit: cover;">';
            }
            return '<span class="text-muted">-</span>';
        });

        $builder->editColumn('status', function (Post $post) {
            $statusLabels = [
                'draft' => '<span class="badge badge-secondary">' . __('blog::translation.draft') . '</span>',
                'published' => '<span class="badge badge-success">' . __('blog::translation.published') . '</span>',
                'private' => '<span class="badge badge-warning">' . __('blog::translation.private') . '</span>',
            ];
            return $statusLabels[$post->status->value] ?? '<span class="badge badge-secondary">' . e($post->status->value) . '</span>';
        });

        return $builder;
    }
}
