<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 *
 * Created by JUZAWEB.
 * Date: 5/31/2021
 * Time: 9:55 PM
 */

namespace Juzaweb\CMS\Abstracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

abstract class DataTable
{
    protected int $perPage = 10;

    protected string $sortName = 'id';

    protected string $sortOder = 'desc';

    protected $params = [];

    protected $dataUrl;

    protected $actionUrl;

    public string $currentUrl;

    /**
     * Columns datatable
     *
     * @return array
     */
    abstract public function columns();

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    abstract public function query($data);

    public function mountData(...$params)
    {
        $params = $this->paramsToArray($params);
        if (method_exists($this, 'mount')) {
            $this->mount(...$params);
        }

        $this->params = $params;
    }

    public function render()
    {
        $uniqueId = 'juzaweb_' . Str::random(10);
        $searchFields = $this->searchFields();
        if (empty($this->currentUrl)) {
            $this->currentUrl = url()->current();
        }

        return view(
            'cms::components.datatable',
            [
                'columns' => $this->columns(),
                'actions' => $this->actions(),
                'uniqueId' => $uniqueId,
                'params' => $this->params,
                'searchFields' => $searchFields,
                'perPage' => $this->perPage,
                'sortName' => $this->sortName,
                'sortOder' => $this->sortOder,
                'dataUrl' => $this->dataUrl,
                'actionUrl' => $this->actionUrl,
                'searchFieldTypes' => $this->getSearchFieldTypes(),
                'table' => Crypt::encryptString(static::class),
            ]
        );
    }

    public function actions()
    {
        return [
            'delete' => trans('cms::app.delete'),
        ];
    }

    public function bulkActions($action, $ids)
    {
        //
    }

    public function searchFields()
    {
        return [
            'keyword' => [
                'type' => 'text',
                'label' => trans('cms::app.keyword'),
                'placeholder' => trans('cms::app.keyword'),
            ],
        ];
    }

    public function rowAction($row)
    {
        return [
            'edit' => [
                'label' => trans('cms::app.edit'),
                'url' => $this->currentUrl .'/'. $row->id . '/edit',
            ],
            'delete' => [
                'label' => trans('cms::app.delete'),
                'class' => 'text-danger',
                'action' => 'delete',
            ],
        ];
    }

    public function rowActionsFormatter($value, $row, $index)
    {
        return view(
            'cms::backend.items.datatable_item',
            [
                'value' => $value,
                'row' => $row,
                'actions' => $this->rowAction($row),
                'editUrl' => $this->currentUrl .'/'. $row->id . '/edit',
            ]
        )
            ->render();
    }

    public function setDataUrl(string $url): void
    {
        $this->dataUrl = $url;
    }

    public function setActionUrl(string $url): void
    {
        $this->actionUrl = $url;
    }

    public function setCurrentUrl(string $url): void
    {
        $this->currentUrl = $url;
    }

    private function paramsToArray($params)
    {
        foreach ($params as $key => $var) {
            if (is_null($var)) {
                continue;
            }

            if (! in_array(gettype($var), ['string', 'array', 'integer'])) {
                throw new \Exception('Mount data can\'t support. Only supported string, array, integer');
            }
        }

        return $params;
    }

    private function getSearchFieldTypes()
    {
        return apply_filters(Action::DATATABLE_SEARCH_FIELD_TYPES_FILTER, []);
    }
}
