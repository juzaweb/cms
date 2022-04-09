<?php

namespace Juzaweb\Crawler\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Crawler\Models\CrawLink;

class LinkDatatable extends DataTable
{
    public $templateId;

    public function mount($templateId)
    {
        $this->templateId = $templateId;
    }

    public function columns()
    {
        return [
            'url' => [
                'label' => trans('cms::app.url'),
            ],
            'status' => [
                'label' => trans('cms::app.status'),
                'width' => '15%',
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ]
        ];
    }

    public function query($data)
    {
        $query = CrawLink::query();
        $query->with('template');
        $query->where('template_id', $this->templateId);

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $builder) use ($keyword) {
                $builder->orWhere(
                    'url',
                    'ilike',
                    '%'. $keyword .'%'
                );
                $builder->orWhere(
                    'error',
                    'ilike',
                    '%'. $keyword .'%'
                );
            });
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function searchFields()
    {
        return [
            'keyword' => [
                'type' => 'text',
                'label' => trans('cms::app.keyword'),
                'placeholder' => trans('cms::app.keyword'),
            ],
            'status' => [
                'type' => 'select',
                'label' => trans('cms::app.status'),
                'options' => CrawLink::getAllStatus(),
            ],
        ];
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                CrawLink::destroy($ids);
                break;
        }
    }
}
