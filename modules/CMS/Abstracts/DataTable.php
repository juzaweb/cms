<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
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
     * @throws \Exception
     */
    public function mountData(...$params)
    {
        $params = $this->paramsToArray($params);
        if (method_exists($this, 'mount')) {
            $this->mount(...$params);
        }

        $this->params = $params;
    }

    /**
     * Renders the view for the PHP function.
     *
     * @return View
     */
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

    /**
     * Returns an array of actions.
     *
     * @return array Returns an array of actions.
     */
    public function actions(): array
    {
        return [
            'delete' => trans('cms::app.delete'),
        ];
    }

    /**
     * A description of the entire PHP function.
     *
     * @param string $action description
     * @param array $ids description
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

    /**
     * Generates a formatted row action for the given value, row, and index.
     *
     * @param mixed $value The value for the row action.
     * @param mixed $row The row object.
     * @param int $index The index of the row.
     * @return string The HTML rendered output of the row action.
     */
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

    /**
     * Sets the data URL for the object.
     *
     * @param string $url The URL to set as the data URL.
     * @throws \Exception
     * @return void
     */
    public function setDataUrl(string $url): void
    {
        $this->dataUrl = $url;
    }

    /**
     * Sets the action URL for the function.
     *
     * @param string $url The URL to set as the action URL.
     * @return void
     */
    public function setActionUrl(string $url): void
    {
        $this->actionUrl = $url;
    }

    /**
     * Set the current URL.
     *
     * @param string $url The URL to set as the current URL.
     * @return void
     */
    public function setCurrentUrl(string $url): void
    {
        $this->currentUrl = $url;
    }

    /**
     * Converts the object to an array.
     *
     * @return array The converted array.
     */
    public function toArray(): array
    {
        $searchFields = collect($this->searchFields())->map(
            function ($item, $key) {
                $item['key'] = $key;
                return $item;
            }
        )->values();

        $columns = collect($this->columns())->map(
            function ($item, $key) {
                $item['key'] = $key;
                $item['sortable'] = Arr::get($item, 'sortable', true);
                unset($item['formatter']);
                return $item;
            }
        )->values();

        $actions = collect($this->actions())->map(
            function ($label, $key) {
                $item['key'] = $key;
                $item['label'] = $label;
                return $item;
            }
        )->values();

        return [
            'columns' => $columns,
            'actions' => $actions,
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
            'uniqueId' => $this->getUniqueId(),
        ];
    }

    /**
     * Retrieves the data to be rendered.
     *
     * @return array Returns an array containing the data to be rendered.
     */
    protected function getDataRender(): array
    {
        $uniqueId = $this->getUniqueId();
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

    /**
     * Generate a unique ID.
     *
     * @return string The unique ID generated.
     */
    protected function getUniqueId(): string
    {
        return 'juzaweb_' . Str::random(10);
    }

    /**
     * Convert the given parameters into an array.
     *
     * @param mixed $params The parameters to convert.
     * @throws \RuntimeException If the parameters contain unsupported types.
     * @return mixed The converted parameters as an array.
     */
    protected function paramsToArray($params)
    {
        foreach ($params as $key => $var) {
            if (is_null($var)) {
                continue;
            }

            if (! in_array(gettype($var), ['string', 'array', 'integer'])) {
                throw new \RuntimeException('Mount data can\'t support. Only supported string, array, integer');
            }
        }

        return $params;
    }

    /**
     * Retrieves the search field types.
     *
     * @return array An array of search field types.
     */
    protected function getSearchFieldTypes()
    {
        return apply_filters(Action::DATATABLE_SEARCH_FIELD_TYPES_FILTER, []);
    }
}
