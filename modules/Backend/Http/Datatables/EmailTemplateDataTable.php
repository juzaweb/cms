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
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Backend\Models\EmailTemplate;
use Juzaweb\CMS\Contracts\HookActionContract;

class EmailTemplateDataTable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'code' => [
                'label' => trans('cms::app.email'),
                'formatter' => [$this, 'rowActionsFormatter'],
                'width' => '30%',
            ],
            'subject' => [
                'label' => trans('cms::app.subject'),
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

    public function rowActionsFormatter($value, $row, $index): string
    {
        return view(
            'cms::backend.items.datatable_item',
            [
                'value' => $value,
                'row' => $row,
                'actions' => $this->rowAction($row),
                'editUrl' => $this->currentUrl .'/'. $row->code . '/edit',
            ]
        )->render();
    }

    public function rowAction($row): array
    {
        return [
            'edit' => [
                'label' => trans('cms::app.edit'),
                'url' => $this->currentUrl .'/'. $row->code . '/edit',
            ],
            'delete' => [
                'label' => trans('cms::app.delete'),
                'class' => 'text-danger',
                'action' => 'delete',
            ],
        ];
    }

    public function query(array $data): Builder
    {
        $query = EmailTemplate::query();

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(
                function (Builder $q) use ($keyword) {
                    $q->orWhere('code', JW_SQL_LIKE, '%'. $keyword .'%');
                    $q->orWhere('subject', JW_SQL_LIKE, '%'. $keyword .'%');
                }
            );
        }

        return $query;
    }

    public function getData(Request $request): array
    {
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = (int) $request->get('limit', 20);
        $page = round(($offset + $limit) / $limit);

        $rows = new Collection();
        if ($page == 1) {
            $templates = app(HookActionContract::class)->getEmailTemplates();
            $exists = EmailTemplate::whereIn('code', $templates->pluck('code')->toArray())
                ->get(['code'])
                ->pluck('code')
                ->toArray();

            foreach ($templates as $template) {
                if (!in_array($template->get('code'), $exists)) {
                    $rows->push(
                        (object) array_merge(
                            $template->toArray(),
                            [
                                'id' => $template->get('code'),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]
                        )
                    );
                }
            }
        }

        $query = $this->query($request->all());
        $count = $query->count() + $rows->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit - $rows->count());
        $rows = $rows->merge($query->get());

        return [$count, $rows];
    }

    public function bulkActions($action, $ids): void
    {
        switch ($action) {
            case 'delete':
                EmailTemplate::destroy($ids);
                break;
        }
    }
}
