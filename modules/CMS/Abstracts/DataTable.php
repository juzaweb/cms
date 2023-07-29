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

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

abstract class DataTable implements Arrayable
{
    /**
     * Number of items per page.
     *
     * @var int
     */
    protected int $perPage = 10;

    /**
     * Name of the attribute used for sorting.
     *
     * @var string
     */
    protected string $sortName = 'id';

    /**
     * Sorting order (asc or desc).
     *
     * @var string
     */
    protected string $sortOder = 'desc';

    /**
     * Additional parameters.
     *
     * @var array
     */
    protected array $params = [];

    /**
     * URL for fetching data.
     *
     * @var string|null
     */
    protected ?string $dataUrl = null;

    /**
     * URL for performing actions.
     *
     * @var string|null
     */
    protected ?string $actionUrl = null;

     /**
     * Array of characters to escape.
     *
     * @var array
     */
    protected array $escapes = [];

    /**
     * Flag indicating whether searching is enabled.
     *
     * @var bool
     */
    protected bool $searchable = true;

    /**
     * Current URL.
     *
     * @var string|null
     */
    public ?string $currentUrl = null;

    public static function make(): static
    {
        return app(static::class);
    }

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
    abstract public function query(array $data);

    /**
     * Retrieves data based on the given request parameters.
     *
     * @param Request $request The request object containing the parameters for data retrieval.
     * @return array The retrieved data in the form of an array with two elements: the total count and the rows.
     */
    public function getData(Request $request): array
    {
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = (int) $request->get('limit', 20);

        $query = $this->query($request->all());
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        return [$count, $rows];
    }

    /**
     * Mounts the data by converting the parameters to an array and calling the mount method if it exists.
     *
     * @param mixed ...$params The parameters to be mounted.
     * @return void
     */
    public function mountData(...$params)
    {
        $params = $this->paramsToArray($params);
        if (method_exists($this, 'mount')) {
            $this->mount(...$params);
        }

        $this->params = $params;
    }

    public function render(): View
    {
        if (empty($this->currentUrl)) {
            $this->currentUrl = url()->current();
        }

        return view(
            'cms::components.datatable',
            $this->getDataRender()
        );
    }

    public function actions(): array
    {
        return [
            'delete' => trans('cms::app.delete'),
        ];
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $action description
     * @param datatype $ids description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function bulkActions($action, $ids)
    {
        //
    }

    /**
     * Retrieves the fields used for searching.
     *
     * @return array The search fields.
     */
    public function searchFields(): array
    {
        return [
            'keyword' => [
                'type' => 'text',
                'label' => trans('cms::app.keyword'),
                'placeholder' => trans('cms::app.keyword'),
            ],
        ];
    }

    /**
     * Generate an array of actions for a given row.
     *
     * @param mixed $row The row for which actions are generated.
     * @return array The array of actions for the given row.
     */
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

    public function rowActionsFormatter($value, $row, $index): string
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

    public function toArray(): array
    {
        $searchFields = $this->searchFields();
        $columns = collect($this->columns())->map(
            function ($item, $key) {
                $item['key'] = $key;
                $item['sortable'] = Arr::get($item, 'sortable', true);
                return $item;
            }
        )->values();

        return [
            'columns' => $columns,
            'actions' => $this->actions(),
            'params' => $this->params,
            'searchFields' => $searchFields,
            'perPage' => $this->perPage,
            'sortName' => $this->sortName,
            'sortOder' => $this->sortOder,
            'dataUrl' => $this->dataUrl,
            'actionUrl' => $this->actionUrl,
            'escapes' => $this->escapes,
            'searchable' => $this->searchable,
            'searchFieldTypes' => $this->getSearchFieldTypes(),
            'table' => Crypt::encryptString(static::class),
        ];
    }

    /**
     * Retrieves the data to be rendered.
     *
     * @return array Returns an array containing the data to be rendered.
     */
    protected function getDataRender(): array
    {
        $uniqueId = 'juzaweb_' . Str::random(10);
        $searchFields = $this->searchFields();

        return [
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
            'escapes' => $this->escapes,
            'searchable' => $this->searchable,
            'searchFieldTypes' => $this->getSearchFieldTypes(),
            'table' => Crypt::encryptString(static::class),
        ];
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
