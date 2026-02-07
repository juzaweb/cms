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
use Juzaweb\Modules\Blog\Models\Category;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;

class CategoriesDataTable extends DataTable
{
    protected string $actionUrl = 'post-categories/bulk';

    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['media'])
            ->withTranslation()
            ->filter(request()->all());
    }

    public function getColumns(): array
    {
        return [
            Column::checkbox(),
            Column::id(),
            Column::editLink('name', admin_url('post-categories/{id}/edit'), __('blog::translation.name')),
            Column::createdAt(),
            Column::actions(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::delete()->can('post-categories.delete'),
            BulkAction::make(__('blog::translation.translate'), null, 'fas fa-language')
                ->type('url')
                ->action('translate')
                ->can('post-categories.edit'),
        ];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("post-categories/{$model->id}/edit"))
                ->can('post-categories.edit'),
            Action::delete()
                ->can('post-categories.delete'),
        ];
    }
}
