<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Datatables\Email;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Backend\Models\EmailTemplate;
use Juzaweb\Backend\Repositories\Email\EmailTemplateRepository;
use Juzaweb\CMS\Abstracts\DataTable;

class EmailHookDataTable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'subject' => [
                'label' => trans('cms::app.subject'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'email_hook' => [
                'label' => trans('cms::app.email_hook'),
                'width' => '30%',
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

    public function query(array $data): Builder
    {
        return app(EmailTemplateRepository::class)
            ->scopeQuery(fn($q) => $q->whereNotNull('email_hook'))
            ->withSearchs(Arr::get($data, 'keyword'))
            ->withFilters($data)
            ->getQuery();
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
